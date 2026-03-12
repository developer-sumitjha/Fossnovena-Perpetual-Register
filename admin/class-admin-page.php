<?php

class FNPR_Admin_Page {

    public function __construct() {

        add_action('admin_menu', [$this, 'register_menu']);
        add_action('admin_menu', [$this, 'register_sub_menu']);
        add_action('admin_menu', [$this, 'register_settings_menu']);

    }

    public function register_menu() {

        add_menu_page(
            'Perpetual Register',
            'Perpetual Register',
            'manage_options',
            'perpetual-register',
            [$this, 'admin_page_html']
        );

    }

    public function register_sub_menu() {
        add_submenu_page(
            'perpetual-register',
            'Import Data',
            'Import Data',
            'manage_options',
            'perpetual-register-import-data',
            [$this, 'import_data_page_html']
        );
    }

    public function register_settings_menu() {
        add_submenu_page(
            'perpetual-register',
            'Settings',
            'Settings',
            'manage_options',
            'perpetual-register-settings',
            [$this, 'settings_page_html']
        );
    }

    public function admin_page_html() {
        ?>

        <div class="wrap">
            <h1 class="fnpr-page-title">Perpetual Register</h1>


        </div>

        <?php
    }

    public function import_data_page_html() {
        ?>

        <div class="wrap">
            <h1 class="fnpr-page-title">Import Data</h1>
            <p class="fnpr-page-description">Import data from CSV files to populate the perpetual register.</p>

            <div class="fnpr-upload-form">
                <form method="post" enctype="multipart/form-data">
                    <input type="file" name="csv_file">

                    <select name="import_type">
                        <option value="append">Append New Data</option>
                        <option value="replace">Replace Existing Data</option>
                    </select>

                    <input type="submit" name="upload_csv" value="Upload">
                </form>
            </div>
        </div>

        <?php
    }

    public function settings_page_html() {
        ?>

        <div class="wrap">
            <h1 class="fnpr-page-title">Settings</h1>
            <p class="fnpr-page-description">Configure the perpetual register settings.</p>

            <div class="fnpr-settings-form">
                
            </div>
        </div>

        <?php
    }

}