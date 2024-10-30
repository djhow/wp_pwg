<?php

/**
 * @package PWG
 */
/*
Plugin Name: Golf: Play the World of Golf
Plugin URI: https://playtheworldatgolf.com/
Description: Play the world at golf
Version: 1.0
Requires at least: 5.0
Requires PHP: 5.2
Author: djhowdydoo
Author URI: https://playtheworldatgolf.com/wordpress-plugins/
License:
Text Domain: pwg
*/

// Make sure we don't expose any info if called directly
if (! function_exists('add_action')) {
    echo 'Hi there! Out of bounds, drop a shot!';
    die;
}


// Define Constants
define('PWG_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Activation, deactivation and uninstall plugin

class PwgPlugin
{
    function __construct()
    {
        // need to ensure that CPT will load at the correct time of wordpress loading
        add_action('plugins_loaded', [$this, 'activate']);
    }

    function activate()
    {
        // generate custom post types
        $this->custom_post_type();
        //flush rewrite rules
        flush_rewrite_rules();
    }


    function deactivate()
    {
        // flush rewrite rules
        flush_rewrite_rules();
    }


    function uninstall()
    {
        // delete custom post types
        // delete all the plugin data from the database
    }

    function register()
    {

        require_once(PWG_PLUGIN_DIR . '/classes/PWG_GolfClub.php');
        require_once(PWG_PLUGIN_DIR . '/classes/PWG_GolfCourse.php');
        require_once(PWG_PLUGIN_DIR . '/classes/PWG_EntityManager.php');
        //require_once(PWG_PLUGIN_DIR . '/classes/holes.php');
        require_once(PWG_PLUGIN_DIR . '/classes/score.php');
        require_once(PWG_PLUGIN_DIR . '/inc/pwgAjax.php');

        require_once(PWG_PLUGIN_DIR . '/classes/PWG_User.php');
        require_once(PWG_PLUGIN_DIR . '/classes/PWG_Golfer.php');
        require_once(PWG_PLUGIN_DIR . '/classes/PWG_Match.php');
        require_once(PWG_PLUGIN_DIR . '/classes/PWG_Club_Meta_Box.php');
        require_once(PWG_PLUGIN_DIR . '/classes/PWG_Course_Meta_Box.php');

        add_action('wp_enqueue_scripts', [$this, 'enqueue_pwg_scripts',]);

        add_action('admin_menu', [$this, 'admin_menus']);

        add_action('show_user_profile', [$this, 'add_homeclub_field']);
        add_action('edit_user_profile', [$this, 'add_homeclub_field']);

        add_action('personal_options_update', [$this, 'save_homeclub_field']);
        add_action('edit_user_profile_update', [$this, 'save_homeclub_field']);

        add_action('show_user_profile', [$this, 'add_handicap_field']);
        add_action('edit_user_profile', [$this, 'add_handicap_field']);

        add_action('personal_options_update', [$this, 'save_handicap_field']);
        add_action('edit_user_profile_update', [$this, 'save_handicap_field']);



        add_action('register_form', [$this, 'extra_registration_fields']);
        add_action('user_register', [$this, 'save_extra_registration_fields']);


        // AJAX
        add_action('wp_ajax_golfclub_search', [$this, 'golfclub_search_callback']);
        add_action('wp_ajax_nopriv_golfclub_search', [$this, 'golfclub_search_callback']);

        // example of ajax from wordpress.org
        add_action('wp_ajax_nopriv_my_tag_count', [$this, 'my_ajax_handler']);
        add_action('wp_ajax_my_tag_count', [$this, 'my_ajax_handler']);

        //add_action('wp_ajax_pwg_add_new_golfclub', [new golfClub(), 'add_new_golfclub']); 
        add_action('wp_ajax_pwg_add_new_golfclub', [PWG_GolfClub::class, 'add_new_golfclub']);
        add_action('wp_ajax_nopriv_pwg_add_new_golfclub', [PWG_GolfClub::class, 'add_new_golfclub']);

        add_action('wp_ajax_update_club', [new PWG_GolfClub(), 'update_club']);
        add_action('wp_ajax_nopriv_update_club', [new PWG_GolfClub(), 'update_club']);


        //add_action('admin_post_save_golf_club', [new PWG_GolfClub(), 'handle_submission']);
        //add_action('admin_post_nopriv_save_golf_club', [new PWG_GolfClub(), 'handle_submission']);

        // End AJAX

        //add_filter( 'the_content', [$this, 'getClub'], 1 );
        //add_filter( 'the_content', [$this, 'getCourse'], 1 );

        add_shortcode('pwg_display', 'pwg_golf_club');

        // Register shortcode to display members list
        add_shortcode('pwg_members', function ($atts) {
            $atts = shortcode_atts([
                'club_id' => 0,
                'layout' => 'table',
                'show_avatar' => true,
                'avatar_size' => 64,
                'sort_by' => 'handicap',
                'sort_order' => 'ASC',
                'limit' => -1
            ], $atts);

            if (empty($atts['club_id'])) {
                return '<p class="pwg-error">Please specify a club ID</p>';
            }

            try {
                $club = new PWG_GolfClub((int)$atts['club_id']);
                return $club->display_members($atts);
            } catch (Exception $e) {
                return '<p class="pwg-error">Error displaying members: ' . esc_html($e->getMessage()) . '</p>';
            }
        });


        // add_action('wp_ajax_find_clubs', 'ajax_find_clubs');
        // add_action('wp_ajax_nopriv_find_clubs', 'ajax_find_clubs');

        /*
        File to handle metaboxes on the admin side for Golfclubs, courses, scorecards etc
        */


        //add_action('add_meta_boxes', [$this, 'add_golf_club_meta_box']);

        // Remove any existing action registrations for 'admin_post_save_golf_course'
        // Add this near the top of your PwgPlugin class registration code:

        add_action('init', function () {
            add_action('admin_post_save_golf_course', [PWG_GolfCourse::class, 'handle_form_submission']);
            add_action('admin_post_nopriv_save_golf_course', function () {
                wp_die('You must be logged in to perform this action.');
            });
        });

        // In your main plugin file:
        add_shortcode('golf_club_form', ['PWG_GolfClub', 'shortcode_handler']);
        add_action('admin_post_save_golf_club', ['PWG_GolfClub', 'handle_submission']);
    }




    function my_ajax_handler()
    {
        // handle ajsx request here
        check_ajax_referer('title_example');
        $title = wp_unslash($_POST['title']);
        update_user_meta(get_current_user_id(), 'title_preference', sanitize_title($title));

        $args      = array(
            'title_preference' => $title,
        );
        $the_query = new WP_Query($args);
        wp_send_json(esc_html($title) . ' (' . $the_query->post_count . ') ');

        wp_die();
    }

    function handle_new_club_form()
    {
        if (isset($_POST['clubname'])) {
            $this->pretty_print($_POST);
        }
    }

    function addNewClub()
    {

        if (isset($_POST['clubname'])) {

            $this->pretty_print($_POST);

            $newClub = new PWG_GolfClub(0);

            $newClub->setName(sanitize_text_field($_POST['clubname']));
            $newClub->setAbout(sanitize_text_field($_POST['aboutclub']));
            $newClub->setAddress(sanitize_text_field($_POST['address_1']));
            //$newClub->setAddress2( sanitize_text_field( $_POST['address_2'] ) );
            //$newClub->setTownCity( sanitize_text_field( $_POST['town_city'] ) );
            //$newClub->setPostcode( sanitize_text_field( $_POST['postcode'] ) );
            //$newClub->setGps( sanitize_text_field( $_POST['gps'] ) );
            $newClub->setContact(sanitize_text_field($_POST['phone']));
            //$newClub->setEmail( sanitize_email( $_POST['email'] ) );
            //$newClub->setFacebook( sanitize_url( $_POST['facebook'] ) );
            //$newClub->setTwitter( sanitize_text_field( $_POST['twitter'] ) );


            //$club_ID = $newClub->insertClub();

            // if ($club_ID){
            //     // insert golf course
            //     $golfcourse = new PWG_GolfCourse();
            // }
        }
    }

    function custom_post_type()
    {

        require_once(PWG_PLUGIN_DIR . '/inc/custom_posts.php');
    }

    function enqueue_pwg_scripts()
    {

        wp_enqueue_style('pwg_style', plugins_url('/assets/css/pwg.css', __FILE__));
        wp_enqueue_script('pwg_js', plugins_url('/assets/js/pwg.js', __FILE__), ['jquery'], '1.0.1', true);


        //wp_enqueue_script('jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array('jquery'), '1.12.1', true);
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-autocomplete');

        // Enqueue child theme stylesheet
        $theme = wp_get_theme();
        wp_enqueue_style('child-style', get_stylesheet_uri(), array(), $theme->get('Version'));



        // enqueue add new golf club page
        if (is_page_template('page-add-golfclub.php')) {
            wp_enqueue_script(
                'add-new-club',
                plugins_url('/assets/js/new-club.js', __FILE__),
                ['jquery'],
                '1.0.0',
                true
            );

            wp_enqueue_style('jquery-ui', plugins_url('/assets/css/jquery-ui.css', __FILE__));

            $new_club_nonce = wp_create_nonce('new_club');

            $local_script = wp_localize_script(
                'add-new-club',
                'my_ajax_obj',
                array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce'    => $new_club_nonce,
                )
            );
        }
    }

    function admin_menus()
    {
        // Register admin code here.
        add_users_page('Golfers Details', 'Golfers Profile', 'administrator', 'golfers_details', [$this, 'golfers_profile']);
    }

    function golfers_profile()
    {

        require_once(PWG_PLUGIN_DIR . '/templates/golfers_profile.php');
    }


    // Add field to user profile
    function add_handicap_field($user)
    {
?>
        <h3>Handicap</h3>
        <table class="form-table">
            <tr>
                <th><label for="handicap">Golf Handicap</label></th>
                <td>
                    <input type="number" name="handicap" value="<?php echo esc_attr(get_the_author_meta('handicap', $user->ID)); ?>" class="regular-text">
                    <p class="description">Please enter your golf handicap.</p>
                </td>
            </tr>
        </table>
<?php
    }

    // Save handicap field
    function save_handicap_field($user_id)
    {
        if (!current_user_can('edit_user', $user_id)) return false;

        update_user_meta($user_id, 'handicap', $_POST['handicap']);
    }

    // add homeclub field to user profile

    function add_homeclub_field($user)
    {

        $clubs = get_posts(array(
            'post_type' => 'golfclub',
            'numberposts' => -1
        ));

        if ($clubs) {
            echo '<h3>Golf Club</h3>';
            echo '<table class="form-table">';
            echo '<tr>';
            echo '<th><label for="homeclub">Your Home Club</label></th>';

            echo '<td>';
            echo '<select name="homeclub" id="homeclub">';
            echo '<option>Select Your Home Club</option>';

            foreach ($clubs as $club) {
                $selected = get_the_author_meta('homeclub', $user->ID) == $club->ID ? 'selected' : '';
                echo '<option value="' . esc_attr($club->ID) . '" ' . $selected . '>' . esc_html($club->post_title) . '</option>';
            }

            echo '</select>';
            echo '<p class="description">Please select your homeclub.</p>';
            echo '<p class="description">Your homeclub is the club you are a member of or the club you play regularly.</p>';
            echo '</td>';
            echo '</tr>';
            echo '</table>';
        }
    }


    function save_homeclub_field($user_id)
    {

        if (!current_user_can('edit_user', $user_id))
            return false;

        update_user_meta($user_id, 'homeclub', $_POST['homeclub']);
    }

    // Add fields to registration page

    function extra_registration_fields()
    {

        // Handicap field
        if ($_POST) {
            $handicap = esc_attr($_POST['handicap']);
        } else {
            $handicap = 0;
        }


        echo '<p>';
        echo '<label for="handicap">Handicap</label>';
        echo '<input type="number" name="handicap" id="handicap" value="' . $handicap . '" class="input" />';
        echo '</p>';

        // Golf club dropdown
        $clubs = get_posts(array(
            'post_type' => 'golfclub',
            'numberposts' => -1
        ));

        echo '<p>';
        echo '<label for="golfclub">Golf Club</label>';

        echo '<select name="golfclub" id="golfclub">';

        foreach ($clubs as $club) {
            echo '<option value="' . esc_attr($club->ID) . '">' . esc_html($club->post_title) . '</option>';
        }

        echo '</select>';
        echo '</p>';
    }

    // Save extra registration fields
    function save_extra_registration_fields($user_id)
    {

        if (! empty($_POST['handicap'])) {
            update_user_meta($user_id, 'handicap', $_POST['handicap']);
        }

        if (! empty($_POST['golfclub'])) {
            update_user_meta($user_id, 'golfclub', $_POST['golfclub']);
        }
    }

    function golfclub_search_callback()
    {
        check_ajax_referer('golfclub_search_nonce', 'security');

        $term = sanitize_text_field($_GET['term']);

        // Customize the query as per your requirements for the golfclub post type
        $args = array(
            'post_type' => 'golfclub',
            's'         => $term,
        );

        $query = new WP_Query($args);
        $results = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $results[] = array(
                    'label' => get_the_title(),
                    'value' => get_the_title(),
                );
            }
        }

        wp_reset_postdata();

        wp_send_json($results);
    }

    // function getClub($content){
    //     if (is_singular('golfclub') && in_the_loop() && is_main_query()) {
    //         $club_ID = get_the_ID();

    //         $golf_club = new PWG_GolfClub($club_ID);

    //         //$content_to_add = $golf_club->showClub();
    //         $content_to_add = $golf_club->toHTML();
    //         if ($content_to_add) {
    //             $content .= $content_to_add;
    //         }
    //         return $content;
    //     }
    //         return $content;
    // }

    // function getCourse($content){
    //     if (is_singular('golfcourse') && in_the_loop() && is_main_query()) {
    //         $course_ID = get_the_ID();

    //         $golf_course = new PWG_GolfCourse($course_ID);
    //         //$holes = new Holes($course_ID);

    //         //$content_to_add = $golf_club->showClub();
    //         $content_to_add = $golf_course->show_course_scorecard();
    //         if ($content_to_add) {
    //             $content .= $content_to_add;
    //         }
    //         return $content;
    //     }
    //         return $content;
    // }

    public function pretty_print($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

if (class_exists('PwgPlugin')) {
    $pwgPlugin = new PwgPlugin();
    $pwgPlugin->register();
    //$pwgPlugin->add_classes();
    // $pwgPlugin->register_scripts();
    // $pwgPlugin->register_shortcodes();
    //$pwgPlugin->register_content_filters();
    // $pwgPlugin->add_admin_menus();
}

// activation
register_activation_hook(__FILE__, [$pwgPlugin, 'activate']);

//deactivation
register_deactivation_hook(__FILE__, [$pwgPlugin, 'deactivate']);


// add actions
add_action('admin_post_club_form_submission', ['pwgGolfClub', 'club_form_submission']);


// function for shortcode
function pwg_golf_club()
{








    //$score_ID = 1;
    //$score = new Score($score_ID);
    //$score->insert_score();
    //$score->edit_score();

    //echo '<pre>';
    //print_r($score);
    //echo '</pre>';


    $club_ID = 8;
    $gc =  new PWG_GolfClub($club_ID);
    // echo $gc->displ();
    // $gc->show_course_scorecard();
    //$holes = new Holes(2);
    // $holes->build_table('front_nine');
    // $holes->build_table('back_nine');
    // $holes->swap_columns();
    // echo '<pre>';
    // print_r($gc);
    // echo '</pre>';
    //$gc->show_edit_scorcard();
    //$c = new golfCourse(2);
    //$d = new golfCourse($c);

    //$golfcourse = new golfCourse($club_ID);

    //$gc->setClubCourses($golfcourse);

    //$gc->setClubCourses($golfcourse);
    //$golf_club->show_golf_club();
    // $golf_club = new golfClub(8);
    // $golf_club->show_edit_scorcard();
    //$golf_club->show_golf_club_submission(); 
    //$golf_club->delete_golf_club(2);
    echo "<p>The Code to mess around with this shortcode is in pwg_golf_club() in golf.php</p>";
}
