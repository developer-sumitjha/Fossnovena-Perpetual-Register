<?php

class FNPR_Admin_Enqueue {

    public function __construct() {

        add_action('admin_enqueue_scripts', [$this, 'enqueue_styles']);

    }

    public function enqueue_styles() {
        wp_enqueue_style( 'fnpr-admin-style', FNPR_PLUGIN_URL . 'assets/css/fnpr-admin.css' );
    }
    

}