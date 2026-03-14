<?php

class FNPR_Ajax_Actions {

    public function __construct() {

        add_action('wp_ajax_fnpr_edit_entry', [$this, 'edit_entry']);
        add_action('wp_ajax_nopriv_fnpr_edit_entry', [$this, 'edit_entry']);
        
        add_action('wp_ajax_fnpr_save_entry', [$this, 'save_entry']);
        add_action('wp_ajax_nopriv_fnpr_save_entry', [$this, 'save_entry']);


        add_action('wp_ajax_fnpr_delete_entry', [$this, 'delete_entry']);
        add_action('wp_ajax_nopriv_fnpr_delete_entry', [$this, 'delete_entry']);
    }

    public function edit_entry() {

        $id = $_POST['id'];
        global $wpdb;
        $table = $wpdb->prefix . 'perpetual_register';
        $entry = $wpdb->get_row("SELECT * FROM $table WHERE id = $id");
        if(!$entry){
            return wp_send_json_error(['message' => 'Entry not found']);
        }
        return wp_send_json_success(['message' => 'Entry edited successfully', 'entry' => $entry]);
    }
    
    public function save_entry(){

        // check_ajax_referer('save_entry_nonce','nonce');
        
        $id = intval($_POST['id']);
        $entry_id = sanitize_text_field($_POST['entry_id']);
        $entry = sanitize_textarea_field($_POST['entry']);
        $life_stats = sanitize_text_field($_POST['life_stats']);
        $sort = sanitize_text_field($_POST['sort']);

        $data = [
            'entry_id'  => $entry_id,
            'entry'     => $entry,
            'life_stats'=> $life_stats,
            'sort'      => $sort
        ];

        $where = [
            'id'    => $id
        ];
        
        global $wpdb;
        $table = $wpdb->prefix . 'perpetual_register';
        $response = $wpdb->update($table ,$data ,$where);

        if($response === false){
            wp_send_json_error([
                'message' => 'Database update failed'
            ]);
        }


        wp_send_json_success([
            'message'=>'Entry saved successfully',
            'response'=>$response
        ]);
    }

    public function delete_entry() {

        $id = $_POST['id'];

        global $wpdb;
        $table = $wpdb->prefix . 'perpetual_register';

        $where = [
            'id'    => $id
        ];

        $response = $wpdb->delete(
            $table, 
            $where
        );
        
        if($response === false){
            wp_send_json_error([
                'message' => 'Database update failed'
            ]);
        }

        wp_send_json_success([
            'message'=>'Delete Respond success.',
            'id'    => $id,
            'response'=> $response
        ]);
    }

}

