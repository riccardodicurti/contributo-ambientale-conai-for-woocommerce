<?php 

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
// only for old plugin versions
$option_name = 'wc_conai_options';
 
delete_option($option_name);
// for site options in Multisite
delete_site_option($option_name);