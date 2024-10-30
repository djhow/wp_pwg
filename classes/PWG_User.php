<?php 

// create a PWG User to hold the WP_User object
class PWG_User {
    public $wp_user;

    public function __construct(WP_User $wp_user){
        $this->wp_user = $wp_user;
    }

    public function get_ID() {
        return $this->wp_user->ID;
    }

    public function get_friendly_name() {
        return $this->wp_user->display_name;
    }

    public function get_email() {
        return $this->wp_user->user_email;
    }

    public function get_user_permalink(){
        return get_author_posts_url($this->wp_user->user_ID);
    }

}