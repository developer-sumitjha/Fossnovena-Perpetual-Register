<?php

class FNPR_Admin_Settings {

    public function __construct(){
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_settings() {

        register_setting(
            'fnpr_settings_group',      // settings group
            'fnpr_reset_database',      // option name
            [
                'type' => 'boolean',
                'sanitize_callback' => 'rest_sanitize_boolean',
                'default' => 0
            ]
        );
    
    }

}