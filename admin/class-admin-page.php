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
            <p class="fnpr-page-description">The perpetual register is a list of all the entries in the register.</p>

            <div class="fnpr-table">
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Entry ID</th>
                            <th>Entry</th>
                            <th>Life Stats</th>
                            <th>Sort</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        global $wpdb;
                        $table = $wpdb->prefix . 'perpetual_register';
                        $entries = $wpdb->get_results("SELECT * FROM $table ORDER BY sort ASC");
                        foreach($entries as $entry){
                            echo '<tr data-id="' . $entry->id . '">';
                            echo '<td>' . $entry->entry_id . '</td>';
                            echo '<td>' . $entry->entry . '</td>';
                            echo '<td>' . $entry->life_stats . '</td>';
                            echo '<td>' . $entry->sort . '</td>';
                            echo '<td><a href="#" class="fnpr-edit-entry">Edit</a> | <a href="#" class="fnpr-delete-entry">Delete</a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="fnpr-modal">
                <div class="fnpr-modal-content">
                    <span class="notice hide"></span>
                    <h2>Edit Entry</h2>
                    <form method="post" class="fnpr-modal-form">
                        <div class="input-field">
                            <input type="hidden" name="id" id="fnpr-edit-entry-id" disabled>
                        </div>
                        <div class="input-field">
                            <label for="fnpr-edit-entryid">Entry ID:</label>
                            <input type="text" name="entry_id" id="fnpr-edit-entryid" placeholder="Entry ID">
                        </div>
                        <div class="input-field">
                            <label for="fnpr-edit-entry-entry">Entry:</label>
                            <input type="text" name="entry" id="fnpr-edit-entry-entry" placeholder="Entry">
                        </div>
                        <div class="input-field">
                            <label for="fnpr-edit-entry-life-stats">Life Stats:</label>
                            <input type="text" name="life_stats" id="fnpr-edit-entry-life-stats" placeholder="Life Stats">
                        </div>
                        <div class="input-field">
                            <label for="fnpr-edit-entry-sort">Sort:</label>
                            <input type="text" name="sort" id="fnpr-edit-entry-sort" placeholder="Sort">
                        </div>
                        <div class="modal-buttons">
                            <input type="button" name="cancel_entry" value="Close" id="cancel-entry">
                            <input type="button" name="save_entry" value="Save" id="save-entry">
                        </div>
                    </form>
                </div>
            </div>


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