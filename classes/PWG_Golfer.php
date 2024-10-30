<?php
class PWG_Golfer // extends PWG_User
{
    private $user_ID;
    private $handicap;
    private $homeclub_ID;
    private $homeclub;

    public function __construct($user_id)
    {
        //parent::__construct($user);
        $this->handicap = get_user_meta($user_id, 'handicap', true) ?: 23;
        $this->homeclub_ID = get_user_meta($user_id, 'homeclub', true) ?: 'Aberdour';
    }

    public function get_homeclub_obj()
    {
        return new PWG_GolfClub($this->get_homeclub_ID());
    }



    // For debugging, you might want to add this temporarily:
    public function debug_info()
    {
        return [
            'user_id' => $this->get_ID(),
            'handicap' => $this->handicap,
            'homeclub' => $this->homeclub,
            'raw_handicap_meta' => get_user_meta($this->get_ID(), 'handicap'),
            'raw_homeclub_meta' => get_user_meta($this->get_ID(), 'homeclub')
        ];
    }

    function debug_golfer_meta()
    {
        global $wpdb;

        // Get current user
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;

        echo "<div style='background: #f5f5f5; padding: 20px; margin: 20px; border: 1px solid #ddd;'>";
        echo "<h3>Golfer Debug Information</h3>";

        // 1. Basic User Info
        echo "<h4>Basic User Information:</h4>";
        echo "User ID: " . $user_id . "<br>";
        echo "Username: " . $current_user->user_login . "<br>";
        echo "Email: " . $current_user->user_email . "<br>";

        // 2. Direct Meta Query
        echo "<h4>All User Meta Data:</h4>";
        $all_meta = get_user_meta($user_id);
        echo "<pre>";
        print_r($all_meta);
        echo "</pre>";

        // 3. Specific Meta Values
        echo "<h4>Specific Meta Values:</h4>";
        echo "Handicap (single): " . get_user_meta($user_id, 'handicap', true) . "<br>";
        echo "Handicap (array): ";
        print_r(get_user_meta($user_id, 'handicap'));
        echo "<br><br>";

        echo "Home Club (single): " . get_user_meta($user_id, 'homeclub', true) . "<br>";
        echo "Home Club (array): ";
        print_r(get_user_meta($user_id, 'homeclub'));
        echo "<br>";

        // 4. Direct Database Query
        echo "<h4>Direct Database Query Results:</h4>";
        $meta_table = $wpdb->prefix . 'usermeta';
        $query = $wpdb->prepare(
            "SELECT meta_key, meta_value 
            FROM $meta_table 
            WHERE user_id = %d 
            AND (meta_key = 'handicap' OR meta_key = 'homeclub')",
            $user_id
        );
        $results = $wpdb->get_results($query);
        echo "<pre>";
        print_r($results);
        echo "</pre>";

        // 5. Test Setting Meta
        echo "<h4>Test Setting Meta Values:</h4>";

        // Only set test values if they don't exist
        if (!get_user_meta($user_id, 'handicap', true)) {
            update_user_meta($user_id, 'handicap', '12');
            echo "Set test handicap value to 12<br>";
        }

        if (!get_user_meta($user_id, 'homeclub', true)) {
            update_user_meta($user_id, 'homeclub', 'Test Golf Club');
            echo "Set test home club value to 'Test Golf Club'<br>";
        }

        // 6. PWG_Golfer Object Test
        echo "<h4>PWG_Golfer Object Test:</h4>";
        $golfer = new PWG_Golfer($current_user);
        echo "Handicap from getter: " . $golfer->get_handicap() . "<br>";
        echo "Home Club from getter: " . $golfer->get_homeclub_ID() . "<br>";

        echo "</div>";
    }
    // Getters /////////////////////
    public function get_handicap()
    {
        return $this->handicap;
    }
    public function get_homeclub_ID()
    {
        return $this->homeclub_ID;
    }
    public function get_homeclub()
    {
        return $this->homeclub;
    }
    public function get_ID()
    {
        return $this->user_ID;
    }
    public function get_friendly_name($user_id)
    {

        return get_the_author_meta('nickname', $user_id);
    }
    // Setters /////////////////////
    public function set_handicap($handicap)
    {
        $this->handicap = $handicap;
        if (! function_exists('add_action')) {
            update_user_meta($this->get_ID(), 'handicap', $handicap);
        }
    }

    public function set_homeclub($homeclub)
    {
        $this->homeclub = $homeclub;
        if (! function_exists('add_action')) {
            update_user_meta($this->get_ID(), 'homeclub', $homeclub);
        }
    }
}
