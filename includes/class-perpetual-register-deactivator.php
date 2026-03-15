<?php

class FNPR_Register_Deactivator {

    public static function deactivate() {

        if (get_option('fnpr_reset_database')) {

            global $wpdb;

            $table = $wpdb->prefix . 'perpetual_register';

            $wpdb->query("DROP TABLE IF EXISTS $table");

        }

    }

}