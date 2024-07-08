<?php

/**
 * Plugin Name:       Contributo Ambientale Conai for WooCommerce
 * Plugin URI:        https://github.com/riccardodicurti/wc_conai
 * GitHub Plugin URI: riccardodicurti/wc_conai
 * Description:       Calcolo del contributo conai in fase di checkout.
 * Version:           1.1.0
 * Author:            Riccardo Di Curti
 * Author URI:        https://riccardodicurti.it/
 * License: 		  GPLv2 or later
 * License URI: 	  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wc_conai
 * Domain Path:       /languages
 */

add_action( 'init', function() {
	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) && is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
		if ( is_admin() ) {
			require __DIR__ . '/includes/settings.php';
		}
	
		add_action( 'woocommerce_product_options_general_product_data', 'wc_conai_product_custom_fields' );
		add_action( 'woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save' );
		add_filter( 'woocommerce_available_variation', 'custom_load_variation_settings_products_fields' );
		add_action( 'woocommerce_cart_calculate_fees', 'wc_conai_weight_add_cart_fee' );
	} else {
		add_action( 'admin_notices', 'wc_conai_admin_error_notice' );
	}
} );

function wc_conai_admin_error_notice() {
	echo esc_html( '<div class="notice error my-acf-notice is-dismissible" ><p>' . __( 'Il plugin WooCommerce "Contributo Ambientale Conai" per funzionare ha bisogno di WooCommerce e ACF Pro attivi', 'wc_conai' ) . '</p></div>' );
}

function wc_conai_product_custom_fields() {
	$options = get_field( 'wc_conai_list', 'option' );

	$woocommerce_wp_select_options = [
		'0' => __( 'Non soggetto a Conai', 'wc_conai' ),
	];

	foreach ( $options as $option ) {
		$woocommerce_wp_select_options[ $option['id'] ] = __( 'Contributo conai ', 'wc_conai' ) . $option['nome'] . ' ' . $option['prezzo'] . '' . $option['unita_di_misura'];
	}

	echo '<div class="product_custom_field">';

	woocommerce_wp_select(
		[
			'id'      => 'wc_conai',
			'label'   => __( 'Conai', 'woocommerce' ),
			'class'   => 'select long',
			'options' => $woocommerce_wp_select_options,
		]
	);

	echo '</div>';
}

function woocommerce_product_custom_fields_save( $post_id ) {
	if ( ! ( isset( $_POST['wc_conai'] ) || wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' ) ) ) {
        return;
    }

	$woocommerce_custom_product_select = filter_var( $_POST['wc_conai'], FILTER_SANITIZE_NUMBER_INT );
	update_post_meta( $post_id, 'wc_conai', $woocommerce_custom_product_select );
}

function custom_load_variation_settings_products_fields( $variations ) {
	$variations['wc_conai'] = get_post_meta( $variations['variation_id'], 'wc_conai', true );

	return $variations;
}

function wc_conai_wc_conai_list_repeater_field() {
	$output = [];
	$repeater_value = get_option( 'options_wc_conai_list' );

	if ( $repeater_value ) {
		for ($i=0; $i<$repeater_value; $i++) {
			$output[] = [
				'id' => get_option("options_wc_conai_list_{$i}_id"),
				'nome' => get_option("options_wc_conai_list_{$i}_nome"),
				'prezzo' => get_option("options_wc_conai_list_{$i}_prezzo"),
				'unita_di_misura' => get_option("options_wc_conai_list_{$i}_unita_di_misura")
			];
		} 
	}

	return $output;
}

function wc_conai_weight_add_cart_fee() {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}

	$options = wc_conai_wc_conai_list_repeater_field() ?: [];
	$all_conai_id = array_column( $options, 'id' );

	$conai_counter_array = [];

	foreach ( $options as $option ) {
		$conai_counter_array[ $option['id'] ] = [
			__( 'Contributo conai ', 'wc_conai' ) . $option['nome'] . ' ' . $option['prezzo'] . '' . $option['unita_di_misura'],
			$option['prezzo'],
			0,
		];
	}

	foreach ( WC()->cart->get_cart() as $cart_item ) {
		if ( $cart_item['data'] instanceof WC_Product_Variation ) {
			$parent_id = $cart_item['data']->parent->id;
		} else {
			$parent_id = $cart_item['data']->get_id();
		}

		$product_conai_class = get_post_meta( $parent_id, 'wc_conai', true );
		$product_weight      = $cart_item['data']->get_weight();

		if ( $product_conai_class && in_array( $product_conai_class, $all_conai_id ) && $product_weight ) {
			$conai_counter_array[ $product_conai_class ][2] += $product_weight * ( $conai_counter_array[ $product_conai_class ][1] / 1000 ) * $cart_item['quantity'];
		}
	}

	foreach ( $conai_counter_array as $conai_item ) {
		if ( $conai_item[2] ) {
			$conai_item[2] = floor( $conai_item[2] * 100 * 1.22 ) / 100;
			WC()->cart->add_fee( $conai_item[0], $conai_item[2], false );
		}
	}
}