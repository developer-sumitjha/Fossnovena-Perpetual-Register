<?php

class FNPR_Shortcode {

    public function __construct() {
        add_shortcode('fnpr_register_list', [$this, 'frontend_shortcode']);
    }

    public function frontend_shortcode($atts){

        ob_start();

        global $wpdb;
        $table = $wpdb->prefix . 'perpetual_register';
        $entries = $wpdb->get_results("SELECT * FROM $table ORDER BY sort ASC");
        ?>
        <div class="container perpetual-register-list">
            <div class="row">
                <div class="col-3">
                    <div class="fnpr-sec-title">

                        <h1 class="m-0">
                            <span class="sub-title">Perpetual</span>
                            <span class="title">Register</span>
                        </h1>
                        <hr>
                        <p>The Perpetual Register records the names of our members who have passed into eternity. Click on the letter to search the Register by surname.</p>
                    </div>
                </div>
                <div class="col-sm-9">

                    <div class="fnpr-alpha-filter">
                        <ul>

                        <li data-filter="all" class="active">All</li>

                        <?php
                            foreach(range('A','Z') as $letter){
                            echo '<li data-filter="'.esc_attr($letter).'">'.esc_html($letter).'</li>';
                            }
                        ?>

                        </ul>
                    </div>
                    <hr>
                    <div class="fnpr-list border">
                    <ul>

                    <?php

                    if(!empty($entries)){

                        foreach($entries as $entry){

                            // Get first letter of entry
                            $first_letter = strtoupper(substr($entry->entry,0,1));

                            ?>

                            <li 
                                data-id="<?php echo esc_attr($entry->id); ?>" 
                                data-letter="<?php echo esc_attr($first_letter); ?>"
                            >

                                <span class="entry-title">
                                    <?php echo esc_html($entry->entry); ?>
                                </span>

                                <span class="entry-lifestats">
                                    <?php echo esc_html($entry->life_stats); ?>
                                </span>

                            </li>

                            <?php
                        }

                    }else{

                        echo '<li>No entries found.</li>';

                    }

                    ?>

                    </ul>
                    </div> 
                </div>
            </div>
        </div>
        


        <script>

        document.addEventListener("DOMContentLoaded", function(){

            const filters = document.querySelectorAll(".fnpr-alpha-filter li");
            const entries = document.querySelectorAll(".fnpr-list li");

            filters.forEach(filter => {

                filter.addEventListener("click", function(){

                    filters.forEach(f => f.classList.remove("active"));
                    this.classList.add("active");

                    const letter = this.getAttribute("data-filter");

                    entries.forEach(entry => {

                        if(letter === "all"){

                            entry.style.display = "flex";

                        }else{

                            if(entry.dataset.letter === letter){
                                entry.style.display = "flex";
                            }else{
                                entry.style.display = "none";
                            }

                        }

                    });

                });

            });

        });

        </script>
        <style>
            .fnpr-sec-title{
                position: sticky;
                top: 0px;
            }
            .perpetual-register-list h1{
                display: flex;
                flex-direction: column;
            }
            .perpetual-register-list .sub-title{
                font-family: 'Times New Roman';
                font-size: 24px;
                color: #0b83c0;
            }
            .perpetual-register-list .title{
                font-family: 'Times New Roman';
                font-size: 52px;
                color: #e14426;
            }
            .perpetual-register-list p{
                font-size: 16px;
            }
            .fnpr-alpha-filter ul {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                justify-content: flex-start;
                list-style-type: none;
                padding: 0;
                margin: 0;
            }
            .perpetual-register-list .col-sm-9 hr {
                margin-top: 40px;
                margin-bottom: 40px;
            }
            .fnpr-alpha-filter ul li{
                font-family: 'Times New Roman';
                background-color: #d7e7f4;
                padding: 12px 24px;
                color: #0b83c0;
                font-weight: 500;
                cursor: pointer;
            }
            .fnpr-list ul {
                list-style-type: none;
                padding: 0;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 16px 40px;
            }
            .fnpr-list ul li {
                display: flex;
                flex-direction: column;
            }
            .fnpr-list ul li .entry-title {
                font-size: 18px;
            }
            .fnpr-list ul li .entry-lifestats {
                font-size: 16px;
            }
        </style>
        <?php
        

        return ob_get_clean();

    }


}