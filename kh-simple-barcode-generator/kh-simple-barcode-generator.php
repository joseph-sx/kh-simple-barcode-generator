<?php
/*
 * Plugin Name:       Simple Barcode Generator
 * Plugin URI:        https://krakenhub.net/
 * Description:       Create basic barcode to be printed taking the SKU field of woocommerce
 * Version:           0.0.2
 * Author:            KRAKENHUB
 * Author URI:        https://krakenhub.net
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html

 */


defined('ABSPATH') || exit;

define('KH_BCG_VERSION', '0.0.2');
define('KH_PATH', plugin_dir_path(__FILE__));

require_once KH_PATH . '/inc/updater.class.php';



/**
 * Setting up Hooks
 */
register_activation_hook(KH_PATH, 'activate');
register_deactivation_hook(KH_PATH, 'deactivate');
add_filter('manage_edit-product_columns', 'kh_add_print_barcode_column', 10, 1);
add_action('manage_product_posts_custom_column', 'kh_add_print_barcode_column_content', 10, 2);
add_action('admin_enqueue_scripts', 'kh_enqueue_admin_files');
/**
 * Activate callback
 */
function activate()
{
    //Activation code in here

}

/**
 * Deactivate callback
 */
function deactivate()
{
    //Deactivation code in here
}

// Add product new column in administration
function kh_add_print_barcode_column($columns){
    //add column
    $columns['print_barcode'] = __('Print Barcode', 'woocommerce');
    return $columns;
}

function kh_add_print_barcode_column_content($column, $postid)
{
    if ($column == 'print_barcode') {
        // Get product object
        $product = wc_get_product($postid);
        echo '<center>
                        <img width="80px" src="https://barcode.khat.es/api/generate?v=' . $product->get_sku() . '&ver=' . KH_BCG_VERSION . '">
                            <br>
                                <a href="#" 
                                data-barcode-value="' . $product->get_sku() . '" 
                                data-item-name="' . $product->get_name() . '" 
                                data-item-price="' . html_entity_decode(strip_tags(wc_price($product->get_price()))) . '" 
                                onclick="printBarcode(this);return false;">Print Barcode</a>
                            <br>
                        </center>';
    }
}

function kh_enqueue_admin_files($hook)
{
    if ('edit.php' !== $hook) {
        return;
    }
    wp_enqueue_script('kh_js_script', plugin_dir_url(__FILE__) . '/kh-functions.js', array(), KH_BCG_VERSION);
}

new KrakenHub\Barcode\Updater();