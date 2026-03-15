<?php

class FNPR_Admin_Page {

    public function __construct() {

        add_action('admin_menu', [$this, 'register_menu']);
        add_action('admin_menu', [$this, 'register_sub_menu']);
        
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
        global $wpdb;
        $table = $wpdb->prefix . 'perpetual_register';

        $per_page = isset($_GET['perpage']) ? intval($_GET['perpage']) : 200;
        $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
        $offset = ($current_page - 1) * $per_page;

       $total_entries = $wpdb->get_var("SELECT COUNT(*) FROM $table");

        $entries = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $table ORDER BY sort ASC LIMIT %d OFFSET %d",
                $per_page,
                $offset
            )
        );

        
        $total_pages = ceil($total_entries / $per_page);
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
                        // $entries = $wpdb->get_results("SELECT * FROM $table ORDER BY sort ASC");

                        if(!empty($entries)){
                        
                            foreach($entries as $entry){
                                echo '<tr data-id="' . $entry->id . '">';
                                echo '<td>' . $entry->entry_id . '</td>';
                                echo '<td>' . $entry->entry . '</td>';
                                echo '<td>' . $entry->life_stats . '</td>';
                                echo '<td>' . $entry->sort . '</td>';
                                echo '<td><a href="#" class="fnpr-edit-entry">Edit</a> | <a href="#" class="fnpr-delete-entry">Delete</a></td>';
                                echo '</tr>';
                            }

                        } else {
                            echo '<tr>';
                            echo '<td colspan="5" style="text-align:center;">No result found</td>';
                            echo '</tr>';
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>

            <div class="tablenav">

            <div class="perpage-select">
            <form method="get">
                <input type="hidden" name="page" value="<?php echo esc_attr($_GET['page']); ?>">
                <select name="perpage" id="perpage-select" onchange="this.form.submit()">
                    <?php
                    $options = [20, 50, 100, 200, 500];
                    foreach ($options as $option) {
                        $selected = $per_page == $option ? 'selected' : '';
                        echo "<option value='$option' $selected>$option</option>";
                    }
                    ?>
                </select>
            </form>
            </div>

            
            <?php 
            // Pagination
            if ($total_entries > $per_page) {
                $total_pages = ceil($total_entries / $per_page);

                echo '<div class="tablenav-pages">';
                echo paginate_links([
                    'base'      => add_query_arg('paged', '%#%'),
                    'format'    => '',
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                    'total'     => $total_pages,
                    'current'   => $current_page,
                    'mid_size'  => 2, // show 2 pages before/after current
                ]);
                echo '</div>';
            } ?>
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

    public function settings_page_html(){
        ?>
        <div class="wrap">
            <h1 class="fnpr-page-title">Settings</h1>
            <p class="fnpr-page-description"></p>

            <form method="post" action="options.php" class="fnpr-settings">

                <?php settings_fields('fnpr_settings_group'); ?>

                <table class="form-table">
                    <tr>
                        <th scope="row">Database Settings</th>
                        <td>
                            <label>
                                <input 
                                    type="checkbox" 
                                    name="fnpr_reset_database" 
                                    value="1"
                                    <?php checked( get_option('fnpr_reset_database'), 1 ); ?>
                                />
                                Reset Database on Plugin Deactivation
                            </label>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>

            </form>
        </div>
        <?php
    }


}