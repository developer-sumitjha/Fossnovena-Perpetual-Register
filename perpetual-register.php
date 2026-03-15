<?php
/**
 * Plugin Name: Fossnovena Perpetual Register
 * Plugin URI: https://fossnovena.org
 * Description: Automates the Perpetual Register by importing CSV files and displaying records dynamically.
 * Version: 1.0.0
 * Author: Sumit Jha
 * Author URI: https://sumitjha.info.np
 * Text Domain: fossnovena-register
 * Domain Path: /languages
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'FNPR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'FNPR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once FNPR_PLUGIN_PATH . 'includes/class-perpetual-register-activator.php';
require_once FNPR_PLUGIN_PATH . 'includes/class-csv-importer.php';
require_once FNPR_PLUGIN_PATH . 'includes/class-ajax-actions.php';
require_once FNPR_PLUGIN_PATH . 'admin/class-admin-page.php';
require_once FNPR_PLUGIN_PATH . 'admin/class-admin-enqueue.php';
require_once FNPR_PLUGIN_PATH . 'public/class-fnpr-shortcode.php';
require_once FNPR_PLUGIN_PATH . 'public/class-fnpr-enqueue.php';


class FNPR_Perpetual_Register {

    public function __construct() {

        add_action( 'init', [ $this, 'init_plugin' ] );

    }

    public function init_plugin() {

        FNPR_Register_Activator::activate();

        new FNPR_Admin_Page();
        new FNPR_Admin_Enqueue();
        new FNPR_CSV_Importer();
        new FNPR_Ajax_Actions();

        new FNPR_Shortcode();
        new FNPR_Public_Enqueue();
        
    }

}

new FNPR_Perpetual_Register();