<?php

class FNPR_Register_Activator {

    static function activate() {

        global $wpdb;

        $table = $wpdb->prefix . 'perpetual_register';

        $charset = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table (
            id INT NOT NULL AUTO_INCREMENT,
            entry_id VARCHAR(255) NOT NULL,
            entry VARCHAR(255) NOT NULL,
            life_stats VARCHAR(255) NOT NULL,
            sort VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

    }

}

register_activation_hook( __FILE__, array( 'FNPR_Register_Activator', 'activate' ) );