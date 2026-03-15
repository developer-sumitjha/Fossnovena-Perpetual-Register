<?php

class FNPR_Public_Enqueue {

    public function __construct() {

        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_styles']);

    }

    public function enqueue_frontend_styles() {

        wp_enqueue_script('fnpr-bootstrap-js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.min.js');
        wp_enqueue_style('fnpr-bootstrap-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/css/bootstrap-grid.min.css');

        // wp_enqueue_style( 'fnpr-admin-style', FNPR_PLUGIN_URL . 'assets/css/fnpr-admin.css' );
        // wp_enqueue_script( 'fnpr-admin-script', FNPR_PLUGIN_URL . 'assets/js/fnpr-admin.js', array('jquery'), '1.0.0', true );
    }
    

}