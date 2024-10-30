<?php
class PwgPlugin{

    function register(){

        add_action( 'wp_enqueue_scripts', [$this,'enqueue_new_club_script'] );
        add_action('wp_ajax_pwg_add_new_golfclub', [$this, 'add_new_golfclub']); 
        
    }

    function enqueue_new_club_script(){

        if ( is_page_template( 'page-add-golfclub.php' )){
            wp_enqueue_script( 'add-new-club',
                            plugins_url('/assets/new-club.js', __FILE__ ),
                            ['jquery'], '1.0.0',
                            true );

            $new_club_nonce = wp_create_nonce( 'new_club' );
            wp_localize_script(
                'add-new-club',
                'my_ajax_obj',
                array(
                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                    'nonce'    => $new_club_nonce,
                )
            );
        } else {
            return;
        }
    }

    function add_new_golfclub(){

        if ( ! is_page_template( 'page-add-golfclub.php' )) {
            return;
        }
        check_ajax_referer( 'new_club' );
        wp_send_json('Ha ha you got to the function');

        wp_die();
    }


}

// this is the javascript that is enqueued by enqueue_new_club_script()
?>
<script>
jQuery(document).ready(function ($) {
    
    $("#add-new-club").submit(function(e) {

        e.preventDefault();
        
        const formData = $("#add-new-club").serialize();
        
        $.post(
            my_ajax_obj.ajax_url,{
            _ajax_nonce: my_ajax_obj.nonce,    
            action: "pwg_add_new_golfclub",
            formData: formData   
            },
            function(response) {
            // Handle response
            console.log(response);
            },
            function(error) {
            // Handle error  
            console.log(error);
            }
        );

    });
});
</script>

<?php

if ( class_exists ( 'PwgPlugin' ) ) {
    $pwgPlugin = new PwgPlugin();
    $pwgPlugin->register();
}
