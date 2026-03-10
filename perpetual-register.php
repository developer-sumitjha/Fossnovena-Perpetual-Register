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


class FNPR_Perpetual_Register {

    public function __construct() {

        add_action( 'init', [ $this, 'init_plugin' ] );

    }

    public function init_plugin() {

        FNPR_Register_Activator::activate();

    }

}

new FNPR_Perpetual_Register();