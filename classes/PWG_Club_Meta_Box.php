<?php
class PWG_Club_Meta_Box
{
    private $prefix = 'pwg_club_';

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_meta_box']);
        add_action('save_post_golfclub', [$this, 'save_meta_box'], 10, 1);
    }

    public function add_meta_box()
    {
        add_meta_box(
            'pwg_club_details',
            'Golf Club Details',
            [$this, 'render_meta_box'],
            'golfclub',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post)
    {
        global $wpdb;

        // Get existing club data directly from database
        $club_meta = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM wp_golf_clubs WHERE club_ID = %d",
            $post->ID
        ));

        // Set default values
        $address = [
            'address1' => '',
            'address2' => '',
            'town_city' => '',
            'county' => '',
            'postcode' => '',
            'gps' => '',
            'website' => ''
        ];

        $contact = [
            'phone' => '',
            'email' => '',
            'facebook' => '',
            'twitter' => ''
        ];

        // If we have existing data, override defaults
        if ($club_meta) {
            $address = [
                'address1' => $club_meta->address_1,
                'address2' => $club_meta->address_2,
                'town_city' => $club_meta->town_city,
                'county' => $club_meta->county,
                'postcode' => $club_meta->postcode,
                'gps' => $club_meta->gps,
                'website' => $club_meta->website
            ];

            $contact = [
                'phone' => $club_meta->phone,
                'email' => $club_meta->email,
                'facebook' => $club_meta->facebook,
                'twitter' => $club_meta->twitter
            ];
        }

        // Add nonce for security
        wp_nonce_field('pwg_club_meta_box', 'pwg_club_meta_box_nonce');

?>
        <div class="pwg-meta-box">
            <style>
                .pwg-meta-box .form-group {
                    margin-bottom: 15px;
                }

                .pwg-meta-box label {
                    display: block;
                    font-weight: 600;
                    margin-bottom: 5px;
                }

                .pwg-meta-box input[type="text"],
                .pwg-meta-box input[type="email"],
                .pwg-meta-box input[type="url"] {
                    width: 100%;
                }

                .pwg-meta-box fieldset {
                    margin-bottom: 20px;
                    padding: 15px;
                    border: 1px solid #ccc;
                }

                .pwg-meta-box legend {
                    font-weight: 600;
                    padding: 0 10px;
                }
            </style>

            <fieldset>
                <legend>Address Information</legend>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>address1">Address Line 1</label>
                    <input type="text" id="<?php echo $this->prefix; ?>address1"
                        name="<?php echo $this->prefix; ?>address1"
                        value="<?php echo esc_attr($address['address1']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>address2">Address Line 2</label>
                    <input type="text" id="<?php echo $this->prefix; ?>address2"
                        name="<?php echo $this->prefix; ?>address2"
                        value="<?php echo esc_attr($address['address2']); ?>">
                </div>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>town_city">Town/City</label>
                    <input type="text" id="<?php echo $this->prefix; ?>town_city"
                        name="<?php echo $this->prefix; ?>town_city"
                        value="<?php echo esc_attr($address['town_city']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>county">County</label>
                    <input type="text" id="<?php echo $this->prefix; ?>county"
                        name="<?php echo $this->prefix; ?>county"
                        value="<?php echo esc_attr($address['county']); ?>">
                </div>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>postcode">Postcode</label>
                    <input type="text" id="<?php echo $this->prefix; ?>postcode"
                        name="<?php echo $this->prefix; ?>postcode"
                        value="<?php echo esc_attr($address['postcode']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>gps">GPS Coordinates</label>
                    <input type="text" id="<?php echo $this->prefix; ?>gps"
                        name="<?php echo $this->prefix; ?>gps"
                        value="<?php echo esc_attr($address['gps']); ?>">
                </div>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>website">Website</label>
                    <input type="url" id="<?php echo $this->prefix; ?>website"
                        name="<?php echo $this->prefix; ?>website"
                        value="<?php echo esc_attr($address['website']); ?>">
                </div>
            </fieldset>

            <fieldset>
                <legend>Contact Information</legend>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>phone">Phone</label>
                    <input type="text" id="<?php echo $this->prefix; ?>phone"
                        name="<?php echo $this->prefix; ?>phone"
                        value="<?php echo esc_attr($contact['phone']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>email">Email</label>
                    <input type="email" id="<?php echo $this->prefix; ?>email"
                        name="<?php echo $this->prefix; ?>email"
                        value="<?php echo esc_attr($contact['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>facebook">Facebook</label>
                    <input type="url" id="<?php echo $this->prefix; ?>facebook"
                        name="<?php echo $this->prefix; ?>facebook"
                        value="<?php echo esc_attr($contact['facebook']); ?>">
                </div>

                <div class="form-group">
                    <label for="<?php echo $this->prefix; ?>twitter">Twitter</label>
                    <input type="url" id="<?php echo $this->prefix; ?>twitter"
                        name="<?php echo $this->prefix; ?>twitter"
                        value="<?php echo esc_attr($contact['twitter']); ?>">
                </div>
            </fieldset>
        </div>
<?php
    }

    public function save_meta_box($post_id)
    {
        // Security checks
        if (
            !isset($_POST['pwg_club_meta_box_nonce']) ||
            !wp_verify_nonce($_POST['pwg_club_meta_box_nonce'], 'pwg_club_meta_box')
        ) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        global $wpdb;

        // Prepare data for database
        $data = [
            'club_ID' => $post_id,
            'address_1' => sanitize_text_field($_POST[$this->prefix . 'address1']),
            'address_2' => sanitize_text_field($_POST[$this->prefix . 'address2']),
            'town_city' => sanitize_text_field($_POST[$this->prefix . 'town_city']),
            'county' => sanitize_text_field($_POST[$this->prefix . 'county']),
            'postcode' => sanitize_text_field($_POST[$this->prefix . 'postcode']),
            'gps' => sanitize_text_field($_POST[$this->prefix . 'gps']),
            'website' => esc_url_raw($_POST[$this->prefix . 'website']),
            'phone' => sanitize_text_field($_POST[$this->prefix . 'phone']),
            'email' => sanitize_email($_POST[$this->prefix . 'email']),
            'facebook' => esc_url_raw($_POST[$this->prefix . 'facebook']),
            'twitter' => esc_url_raw($_POST[$this->prefix . 'twitter'])
        ];

        // Check if record exists
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT club_ID FROM wp_golf_clubs WHERE club_ID = %d",
            $post_id
        ));

        // Insert or update based on existence
        if ($exists) {
            $wpdb->update('wp_golf_clubs', $data, ['club_ID' => $post_id]);
        } else {
            $wpdb->insert('wp_golf_clubs', $data);
        }
    }
}

// Initialize the meta box
function init_pwg_club_meta_box()
{
    new PWG_Club_Meta_Box();
}
add_action('init', 'init_pwg_club_meta_box');
