<?php
class PWG_GolfClub
{

    /**
     * Outputs an HTML5 form for creating or editing a golf club.
     *
     * @param string $action The form action URL
     * @param string $method The form method (GET or POST)
     * @return string HTML representation of the form
     */
    public function toHTMLForm()
    {
        $html = "<form action='" . esc_url(admin_url('admin-post.php')) . "' method='POST' class='golf-club-form'>";
        $html .= wp_nonce_field('save_golf_club', 'golf_club_nonce', true, false);

        // Add a hidden field for the club ID if it exists
        if ($this->id) {
            $html .= "<input type='hidden' name='club_id' value='" . esc_attr($this->id) . "'>";
        }
        $html .= "<input type='hidden' name='action' value='save_golf_club'>";

        $html .= "<fieldset>";
        $html .= "<legend>Club Details</legend>";

        $html .= "<label for='club_name'>Club Name:</label>";
        $html .= "<input type='text' id='club_name' name='club_name' value='" . esc_attr($this->getName()) . "' required>";

        $html .= "<label for='club_about'>About the Club:</label>";
        $html .= "<textarea id='club_about' name='club_about' rows='5'>" . esc_textarea($this->getAbout()) . "</textarea>";

        $html .= "</fieldset>";

        $html .= "<fieldset>";
        $html .= "<legend>Address</legend>";

        $html .= "<label for='address_1'>Address Line 1:</label>";
        $html .= "<input type='text' id='address_1' name='address_1' value='" . esc_attr($this->address['address1']) . "' required>";

        $html .= "<label for='address_2'>Address Line 2:</label>";
        $html .= "<input type='text' id='address_2' name='address_2' value='" . esc_attr($this->address['address2']) . "'>";

        $html .= "<label for='town_city'>Town/City:</label>";
        $html .= "<input type='text' id='town_city' name='town_city' value='" . esc_attr($this->address['town_city']) . "' required>";

        $html .= "<label for='county'>County:</label>";
        $html .= "<input type='text' id='county' name='county' value='" . esc_attr($this->address['county']) . "'>";

        $html .= "<label for='country'>Country:</label>";
        $html .= "<input type='text' id='country' name='country' value='" . esc_attr($this->address['country']) . "' required>";

        $html .= "<label for='postcode'>Postcode:</label>";
        $html .= "<input type='text' id='postcode' name='postcode' value='" . esc_attr($this->address['postcode']) . "' required>";

        $html .= "<label for='website'>Website:</label>";
        $html .= "<input type='text' id='website' name='website' value='" . esc_attr($this->address['website']) . "' required>";

        $html .= "<label for='gps'>GPS Coordinates:</label>";
        $html .= "<input type='text' id='gps' name='gps' value='" . esc_attr($this->address['gps']) . "'>";

        $html .= "</fieldset>";

        $html .= "<fieldset>";
        $html .= "<legend>Contact Information</legend>";

        $html .= "<label for='phone'>Phone:</label>";
        $html .= "<input type='tel' id='phone' name='phone' value='" . esc_attr($this->contact['phone']) . "' required>";

        $html .= "<label for='email'>Email:</label>";
        $html .= "<input type='email' id='email' name='email' value='" . esc_attr($this->contact['email']) . "' required>";

        $html .= "<label for='facebook'>Facebook:</label>";
        $html .= "<input type='url' id='facebook' name='facebook' value='" . esc_attr($this->contact['facebook']) . "'>";

        $html .= "<label for='twitter'>Twitter:</label>";
        $html .= "<input type='url' id='twitter' name='twitter' value='" . esc_attr($this->contact['twitter']) . "'>";

        $html .= "</fieldset>";

        $html .= "<button type='submit'>Save Golf Club</button>";

        $html .= "</form>";

        return $html;
    }

    function handle_golf_club_form_submission()
    {
        // Verify nonce
        if (!isset($_POST['golf_club_nonce']) || !wp_verify_nonce($_POST['golf_club_nonce'], 'save_golf_club')) {
            wp_die('Security check failed');
        }

        // Check user capabilities
        if (!current_user_can('edit_posts')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        $club_id = isset($_POST['club_id']) ? intval($_POST['club_id']) : 0;
        $club = new PWG_GolfClub($club_id);

        // Update club properties based on form data
        $club->setName(sanitize_text_field($_POST['club_name']));
        $club->setAbout(sanitize_textarea_field($_POST['club_about']));
        $club->validateCreatedBy();

        // Update address information
        $club->setAddress([
            'address1' => sanitize_text_field($_POST['address_1']),
            'address2' => sanitize_text_field($_POST['address_2']),
            'town_city' => sanitize_text_field($_POST['town_city']),
            'county' => sanitize_text_field($_POST['county']),
            'country' => sanitize_text_field($_POST['country']),
            'postcode' => sanitize_text_field($_POST['postcode']),
            'gps' => sanitize_text_field($_POST['gps']),
            'website' => sanitize_text_field($_POST['website'])
        ]);

        // Update contact information
        $club->setContact([
            'phone' => sanitize_text_field($_POST['phone']),
            'email' => sanitize_email($_POST['email']),
            'facebook' => esc_url_raw($_POST['facebook']),
            'twitter' => esc_url_raw($_POST['twitter'])
        ]);

        // Save the club
        $club->save();

        // Redirect back to the form or to a success page
        wp_redirect(add_query_arg('updated', 'true', wp_get_referer()));
        exit;
    }
}
