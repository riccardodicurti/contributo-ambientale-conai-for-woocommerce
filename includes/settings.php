<?php

// var_dump( // get_field( 'wc_conai_list' ) );

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' => 'WooCommerce Contributo Conai',
        'menu_title' => 'WooCommerce Conai',
        'menu_slug' => 'wc_conai_settings',
        'capability' => 'manage_woocommerce',
        'redirect' => false
    ));

    acf_add_local_field_group(array(
        'key' => 'group_6228e877999a1',
        'title' => 'Pagina Opzioni',
        'fields' => array(
            array(
                'key' => 'field_6228e9fcfdd66',
                'label' => 'Entry conai',
                'name' => 'wc_conai_list',
                'type' => 'repeater',
                'instructions' => 'Inserire l\'elenco delle entry conai',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => '',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Aggiungi nuova entry',
                'sub_fields' => array(
                    array(
                        'key' => 'field_6228ea3cfdd67',
                        'label' => 'id',
                        'name' => 'id',
                        'type' => 'number',
                        'instructions' => 'Inserire un identificativo diverso per ogni entry',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => 1,
                        'max' => '',
                        'step' => 1,
                    ),
                    array(
                        'key' => 'field_6228ea93fdd68',
                        'label' => 'nome',
                        'name' => 'nome',
                        'type' => 'text',
                        'instructions' => 'Inserire il nome della entry',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_6228ead3fdd69',
                        'label' => 'prezzo',
                        'name' => 'prezzo',
                        'type' => 'number',
                        'instructions' => 'Inserire il prezzo della entry',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => 1,
                        'max' => '',
                        'step' => '',
                    ),
                    array(
                        'key' => 'field_6228eaf6fdd6a',
                        'label' => 'unità di misura',
                        'name' => 'unita_di_misura',
                        'type' => 'text',
                        'instructions' => 'Inserire l\'unità di misura della entry',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '€ per 1000kg',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'wc_conai_settings',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

}

function wc_conai_options_page() {
    add_menu_page(
        'WooCommerce Contributo Conai',
        'WooCommerce Conai',
        'manage_woocommerce',
        'wc_conai',
        'wc_conai_options_page_html'
    );
}
// add_action( 'admin_menu', 'wc_conai_options_page' );

function wc_conai_settings_init() {
    register_setting( 'wc_conai', 'wc_conai_options' );

    add_settings_section(
        'wc_conai_section_developers',
        __( 'Impostazioni per la gestione del conai.', 'wc_conai' ),
        'wc_conai_section_developers_cb',
        'wc_conai'
    );

    add_settings_field(
        'wc_conai_field_json',
        __( 'json', 'wc_conai' ),
        'wc_conai_json_cb',
        'wc_conai',
        'wc_conai_section_developers',
        [
            'label_for' => 'wc_conai_json',
            // 'class' => 'wc_conai_row hidden'
            'class' => 'wc_conai_row'
        ]
    );
}
// add_action( 'admin_init', 'wc_conai_settings_init' );
 
function wc_conai_section_developers_cb( $args ) {
    ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Compila tutte le setioni per attivare il servizio.', 'wc_conai' ); ?></p>
    <?php
}

function wc_conai_json_cb( $args ) {
    $options = get_option( 'wc_conai_options' );
    ?>

        <textarea id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['wc_conai_custom_data'] ); ?>" name="wc_conai_options[<?php echo esc_attr( $args['label_for'] ); ?>]" rows="4" cols="50"><?php echo isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : ''; ?></textarea>

        <pre class="description">
            <?php // esc_html_e( 'I valori attualmente impoostati sono presi da https://www.cial.it/wp-content/uploads/2016/01/Guida_Contributo_CONAI_2020_Vol1.pdf', 'wc_conai' ); ?>
        </pre>
    <?php
}
 
function wc_conai_options_page_html() {
    if ( ! current_user_can( 'manage_woocommerce' ) ) {
        return;
    }

    if ( isset( $_GET['settings-updated'] ) ) {

        $options = get_option( 'wc_conai_options' );
        $wc_conai_json = json_decode($options['wc_conai_json']);

        if($wc_conai_json === null) {
            add_settings_error( 'wc_conai_messages', 'wc_conai_message', __( 'Json errato', 'wc_conai' ), 'error' );
        } else {
            add_settings_error( 'wc_conai_messages', 'wc_conai_message', __( 'Settings Saved', 'wc_conai' ), 'updated' );
        }
    }

    settings_errors( 'wc_conai_messages' );
    ?> 
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
                settings_fields( 'wc_conai' );
                do_settings_sections( 'wc_conai' );
                submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}