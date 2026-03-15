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
                $row_count = 0;

                while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){

                    // Skip empty rows
                    if (empty(array_filter($data))) {
                        continue;
                    }

                    $life_stats = mb_convert_encoding($data[2], 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');

                    $life_stats = str_replace(['–','—','Ð'], '-', $life_stats);                  

                    $wpdb->insert($table, [
                        'entry_id' => sanitize_text_field($data[0]),
                        'entry' => sanitize_text_field($data[1]),
                        'life_stats' => $life_stats,
                        'sort' => sanitize_text_field($data[3]),
                    ]);
                    $row_count++;

                }

                fclose($handle);

                // Success notice
                add_action('admin_notices', function() use ($row_count) {

                    echo '<div class="notice notice-success is-dismissible">';
                    echo '<p>CSV imported <strong>'.$row_count.'</strong> rows successfully.</p>';
                    echo '</div>';
    
                });
                

            }

        }

    }

}