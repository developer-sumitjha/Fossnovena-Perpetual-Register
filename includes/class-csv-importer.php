<?php

class FNPR_CSV_Importer {

    public function __construct() {

        add_action('admin_init', [$this, 'handle_csv_upload']);

    }

    public function handle_csv_upload() {

        if(isset($_POST['upload_csv'])){

            


            $file = $_FILES['csv_file']['tmp_name'];

            if(($handle = fopen($file, "r")) !== FALSE){

                fgetcsv($handle);

                global $wpdb;

                $table = $wpdb->prefix . 'perpetual_register';

                $import_type = $_POST["import_type"];

                if($import_type == "replace"){
                    $wpdb->query("TRUNCATE TABLE $table");
                }

                while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){

                    // Skip empty rows
                    if (empty(array_filter($data))) {
                        continue;
                    }

                    $wpdb->insert($table, [
                        'entry_id' => sanitize_text_field($data[0]),
                        'entry' => sanitize_text_field($data[1]),
                        'life_stats' => sanitize_text_field($data[2]),
                        'sort' => sanitize_text_field($data[3]),
                    ]);

                }

                fclose($handle);

                // Success notice
                add_action('admin_notices', function() {
                    echo '<div class="notice notice-success"><p>CSV imported successfully.</p></div>';
                });
                

            }

        }

    }

}