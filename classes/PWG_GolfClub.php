<?php

class PWG_GolfClub
{
    private $id;
    private $club_data;

    /**
     * Constructor only accepts an ID and loads minimal data
     * 
     * @param int|null $id The club ID
     */
    public function __construct(?int $id = null)
    {
        if ($id) {
            $this->id = $id;
            // Only load basic post data initially
            $post = get_post($id);
            if (!$post || $post->post_type !== 'golfclub') {
                throw new Exception('Invalid golf club ID');
            }
        }
    }

    /**
     * Static method to get basic club data without instantiating an object
     * 
     * @param int $club_id The club ID
     * @return array|false Club data or false if not found
     */
    public static function get_club_data(int $club_id): array|false
    {
        global $wpdb;

        // First verify the post exists and is published
        $post = get_post($club_id);
        if (!$post || $post->post_type !== 'golfclub' || $post->post_status !== 'publish') {
            return false;
        }

        // Get club metadata from custom table
        $club_meta = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM wp_golf_clubs WHERE club_ID = %d",
            $club_id
        ), ARRAY_A);

        if (!$club_meta) {
            return false;
        }

        // Return combined data
        return [
            'id' => $club_id,
            //'name' => $post->post_title,
            //'description' => $post->post_content,
            'address' => [
                'address1' => $club_meta['address_1'],
                'address2' => $club_meta['address_2'],
                'town_city' => $club_meta['town_city'],
                'county' => $club_meta['county'],
                'country' => $club_meta['country'],
                'postcode' => $club_meta['postcode'],
                'gps' => $club_meta['gps'],
                'website' => $club_meta['website']
            ],
            'contact' => [
                'phone' => $club_meta['phone'],
                'email' => $club_meta['email'],
                'facebook' => $club_meta['facebook'],
                'twitter' => $club_meta['twitter']
            ]
        ];
    }

    /**
     * Static method to get list of courses for a club without loading full objects
     * 
     * @param int $club_id The club ID
     * @return array Array of course data
     */
    public static function get_club_courses(int $club_id): array
    {
        global $wpdb;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT c.course_ID, p.post_title  as name, c.blue_par_total, c.white_par_total 
             FROM wp_golf_courses c
             JOIN wp_posts p ON p.ID = c.course_ID
             WHERE c.club_ID = %d AND p.post_status = 'publish'
             ORDER BY p.post_title",
            $club_id
        ), ARRAY_A);
    }

    /**
     * Static method to render club details without instantiating an object
     * 
     * @param int $club_id The club ID
     * @return string HTML output
     */
    public static function render_club_details(int $club_id): string
    {
        $club_data = self::get_club_data($club_id);
        if (!$club_data) {
            return '<p>Club not found</p>';
        }

        ob_start();
?>
        <article class="golf-club">


            <div class="club-address">
                <h3>Location</h3>
                <address>
                    <?php echo esc_html($club_data['address']['address1']); ?><br>
                    <?php if ($club_data['address']['address2']): ?>
                        <?php echo esc_html($club_data['address']['address2']); ?><br>
                    <?php endif; ?>
                    <?php echo esc_html($club_data['address']['town_city']); ?><br>
                    <?php echo esc_html($club_data['address']['postcode']); ?>
                </address>
                <?php if ($club_data['address']['gps']): ?>
                    <p class="gps">GPS: <?php echo esc_html($club_data['address']['gps']); ?></p>
                <?php endif; ?>
            </div>

            <div class="club-contact">
                <h3>Contact Details</h3>
                <ul>
                    <li>Phone: <a href="tel:<?php echo esc_attr($club_data['contact']['phone']); ?>">
                            <?php echo esc_html($club_data['contact']['phone']); ?></a></li>
                    <li>Email: <a href="mailto:<?php echo esc_attr($club_data['contact']['email']); ?>">
                            <?php echo esc_html($club_data['contact']['email']); ?></a></li>
                </ul>
            </div>

            <?php
            // Only load courses if we're viewing the full club page
            if (is_singular('golfclub')):
                $courses = self::get_club_courses($club_id);
                if ($courses): ?>
                    <div class="club-courses">
                        <h3>Our Courses</h3>
                        <ul>
                            <?php foreach ($courses as $course): ?>
                                <li>
                                    <a href="<?php echo esc_url(get_permalink($course['course_ID'])); ?>">
                                        <?php echo esc_html($course['name']); ?>
                                        (Par <?php echo esc_html($course['white_par_total']); ?>)
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
            <?php endif;
            endif; ?>
        </article>
        <?php
        return ob_get_clean();
    }



    /**
     * Save club data - only instantiate object when modifying data
     * 
     * @param array $data Club data to save
     * @return int|WP_Error Club ID or error
     */
    public static function save_club(array $data): int|WP_Error
    {
        try {
            // Validate required fields
            $required = ['name', 'postcode'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Missing required field: {$field}");
                }
            }

            // Create/update WordPress post
            $post_data = [
                'post_type' => 'golfclub',
                'post_status' => 'publish',
                'post_title' => sanitize_text_field($data['name']),
                'post_content' => wp_kses_post($data['description'] ?? ''),
            ];

            if (!empty($data['id'])) {
                $post_data['ID'] = $data['id'];
                $club_id = wp_update_post($post_data);
            } else {
                $club_id = wp_insert_post($post_data);
            }

            if (is_wp_error($club_id)) {
                return $club_id;
            }

            // Save to custom table
            global $wpdb;
            $table_data = [
                'club_ID' => $club_id,
                'address_1' => sanitize_text_field($data['address1']),
                'address_2' => sanitize_text_field($data['address2'] ?? ''),
                'town_city' => sanitize_text_field($data['town_city']),
                'county' => sanitize_text_field($data['county'] ?? ''),
                'country' => sanitize_text_field($data['country'] ?? ''),
                'postcode' => sanitize_text_field($data['postcode']),
                'gps' => sanitize_text_field($data['gps'] ?? ''),
                'website' => esc_url_raw($data['website'] ?? ''),
                'phone' => sanitize_text_field($data['phone']),
                'email' => sanitize_email($data['email']),
                'facebook' => esc_url_raw($data['facebook'] ?? ''),
                'twitter' => esc_url_raw($data['twitter'] ?? '')
            ];

            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT club_ID FROM wp_golf_clubs WHERE club_ID = %d",
                $club_id
            ));

            if ($exists) {
                $wpdb->update('wp_golf_clubs', $table_data, ['club_ID' => $club_id]);
            } else {
                $wpdb->insert('wp_golf_clubs', $table_data);
            }

            return $club_id;
        } catch (Exception $e) {
            return new WP_Error('club_save_failed', $e->getMessage());
        }
    }

    // Keep constructor-based methods for when we need full object functionality
    public function load_club_data()
    {
        if (!$this->id) {
            throw new Exception('No club ID set');
        }
        $this->club_data = self::get_club_data($this->id);
        if (!$this->club_data) {
            throw new Exception('Club data not found');
        }
    }

    public function update(array $data)
    {
        $data['id'] = $this->id;
        return self::save_club($data);
    }
    public static function pretty_print($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

    /**
     * Display members of a golf club with their details
     * 
     * @param int $club_id The ID of the golf club
     * @param array $args Optional arguments to customize display
     * @return string HTML output of members list
     */
    function pwg_display_club_members(int $club_id, array $args = []): string
    {
        // Default arguments
        $defaults = [
            'show_avatar' => true,
            'avatar_size' => 64,
            'sort_by' => 'handicap', // Options: 'handicap', 'name', 'joined'
            'sort_order' => 'ASC',
            'limit' => -1,
            'layout' => 'table' // Options: 'table', 'grid', 'list'
        ];
        $args = wp_parse_args($args, $defaults);

        // Get all WordPress users
        $users = get_users([
            'meta_key' => 'homeclub',
            'meta_value' => $club_id,
            'meta_type' => 'NUMERIC',
            'number' => $args['limit']
        ]);

        if (empty($users)) {
            return '<p class="pwg-no-members">No members found for this club.</p>';
        }

        // Build array of member data for sorting
        $members = [];
        foreach ($users as $user) {
            $members[] = [
                'id' => $user->ID,
                'name' => $user->display_name,
                'handicap' => get_user_meta($user->ID, 'handicap', true) ?: '999', // Use 999 for users without handicap
                'avatar' => get_avatar($user->ID, $args['avatar_size']),
                'profile_url' => get_author_posts_url($user->ID)
            ];
        }

        // Sort members
        usort($members, function ($a, $b) use ($args) {
            switch ($args['sort_by']) {
                case 'handicap':
                    return $args['sort_order'] === 'ASC' ?
                        $a['handicap'] <=> $b['handicap'] :
                        $b['handicap'] <=> $a['handicap'];
                case 'name':
                    return $args['sort_order'] === 'ASC' ?
                        strcasecmp($a['name'], $b['name']) :
                        strcasecmp($b['name'], $a['name']);
                default:
                    return 0;
            }
        });

        ob_start();

        echo '<div class="pwg-members-list">';

        if ($args['layout'] === 'table') {
        ?>
            <table class="pwg-members-table">
                <thead>
                    <tr>
                        <?php if ($args['show_avatar']): ?>
                            <th class="pwg-member-avatar"></th>
                        <?php endif; ?>
                        <th class="pwg-member-name">Name</th>
                        <th class="pwg-member-handicap">Handicap</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                        <tr>
                            <?php if ($args['show_avatar']): ?>
                                <td class="pwg-member-avatar"><?php echo $member['avatar']; ?></td>
                            <?php endif; ?>
                            <td class="pwg-member-name">
                                <a href="<?php echo esc_url($member['profile_url']); ?>">
                                    <?php echo esc_html($member['name']); ?>
                                </a>
                            </td>
                            <td class="pwg-member-handicap">
                                <?php echo $member['handicap'] === '999' ? 'N/A' : esc_html($member['handicap']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
        } elseif ($args['layout'] === 'grid') {
            echo '<div class="pwg-members-grid">';
            foreach ($members as $member) {
            ?>
                <div class="pwg-member-card">
                    <?php if ($args['show_avatar']): ?>
                        <div class="pwg-member-avatar"><?php echo $member['avatar']; ?></div>
                    <?php endif; ?>
                    <h3 class="pwg-member-name">
                        <a href="<?php echo esc_url($member['profile_url']); ?>">
                            <?php echo esc_html($member['name']); ?>
                        </a>
                    </h3>
                    <div class="pwg-member-handicap">
                        Handicap: <?php echo $member['handicap'] === '999' ? 'N/A' : esc_html($member['handicap']); ?>
                    </div>
                </div>
            <?php
            }
            echo '</div>';
        } else { // list layout
            echo '<ul class="pwg-members-list">';
            foreach ($members as $member) {
            ?>
                <li class="pwg-member-item">
                    <?php if ($args['show_avatar']): ?>
                        <div class="pwg-member-avatar"><?php echo $member['avatar']; ?></div>
                    <?php endif; ?>
                    <div class="pwg-member-details">
                        <span class="pwg-member-name">
                            <a href="<?php echo esc_url($member['profile_url']); ?>">
                                <?php echo esc_html($member['name']); ?>
                            </a>
                        </span>
                        <span class="pwg-member-handicap">
                            (<?php echo $member['handicap'] === '999' ? 'N/A' : esc_html($member['handicap']); ?>)
                        </span>
                    </div>
                </li>
        <?php
            }
            echo '</ul>';
        }

        echo '</div>';

        return ob_get_clean();
    }

    /**
     * Display members of this golf club with their details
     * 
     * @param array $args Optional arguments to customize display
     * @return string HTML output of members list
     */
    public function display_members(array $args = []): string
    {
        if (!$this->id) {
            throw new Exception('No club ID set');
        }

        // Default arguments
        $defaults = [
            'show_avatar' => true,
            'avatar_size' => 64,
            'sort_by' => 'handicap', // Options: 'handicap', 'name', 'joined'
            'sort_order' => 'ASC',
            'limit' => -1,
            'layout' => 'table' // Options: 'table', 'grid', 'list'
        ];
        $args = wp_parse_args($args, $defaults);

        // Get all WordPress users with this homeclub
        $users = get_users([
            'meta_key' => 'homeclub',
            'meta_value' => $this->id,
            'meta_type' => 'NUMERIC',
            'number' => $args['limit']
        ]);

        if (empty($users)) {
            return '<p class="pwg-no-members">No members found for ' . esc_html($this->club_data['name']) . '</p>';
        }

        // Build array of member data for sorting
        $members = [];
        foreach ($users as $user) {
            $members[] = [
                'id' => $user->ID,
                'name' => $user->display_name,
                'handicap' => get_user_meta($user->ID, 'handicap', true) ?: '999',
                'avatar' => get_avatar($user->ID, $args['avatar_size']),
                'profile_url' => get_author_posts_url($user->ID)
            ];
        }

        // Sort members
        usort($members, function ($a, $b) use ($args) {
            switch ($args['sort_by']) {
                case 'handicap':
                    return $args['sort_order'] === 'ASC' ?
                        $a['handicap'] <=> $b['handicap'] :
                        $b['handicap'] <=> $a['handicap'];
                case 'name':
                    return $args['sort_order'] === 'ASC' ?
                        strcasecmp($a['name'], $b['name']) :
                        strcasecmp($b['name'], $a['name']);
                default:
                    return 0;
            }
        });

        // Start output buffering
        ob_start();

        // Add club name as header
        echo '<h2 class="pwg-members-title">' . esc_html($this->club_data['name']) . ' Members</h2>';
        echo '<div class="pwg-members-list">';

        if ($args['layout'] === 'table') {
            $this->render_members_table($members, $args);
        } elseif ($args['layout'] === 'grid') {
            $this->render_members_grid($members, $args);
        } else {
            $this->render_members_list($members, $args);
        }

        echo '</div>';

        return ob_get_clean();
    }

    /**
     * Render members in table layout
     */
    private function render_members_table(array $members, array $args): void
    {
        ?>
        <h3>Members</h3>
        <table class="pwg-members-table">
            <thead>
                <tr>
                    <?php if ($args['show_avatar']): ?>
                        <th class="pwg-member-avatar"></th>
                    <?php endif; ?>
                    <th class="pwg-member-name">Name</th>
                    <th class="pwg-member-handicap">Handicap</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                    <tr>
                        <?php if ($args['show_avatar']): ?>
                            <td class="pwg-member-avatar"><?php echo $member['avatar']; ?></td>
                        <?php endif; ?>
                        <td class="pwg-member-name">
                            <a href="<?php echo esc_url($member['profile_url']); ?>">
                                <?php echo esc_html($member['name']); ?>
                            </a>
                        </td>
                        <td class="pwg-member-handicap">
                            <?php echo $member['handicap'] === '999' ? 'N/A' : esc_html($member['handicap']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * Render members in grid layout
     */
    private function render_members_grid(array $members, array $args): void
    {
        echo '<h3>Members</h3><div class="pwg-members-grid">';
        foreach ($members as $member) {
        ?>
            <div class="pwg-member-card">
                <?php if ($args['show_avatar']): ?>
                    <div class="pwg-member-avatar"><?php echo $member['avatar']; ?></div>
                <?php endif; ?>
                <h3 class="pwg-member-name">
                    <a href="<?php echo esc_url($member['profile_url']); ?>">
                        <?php echo esc_html($member['name']); ?>
                    </a>
                </h3>
                <div class="pwg-member-handicap">
                    Handicap: <?php echo $member['handicap'] === '999' ? 'N/A' : esc_html($member['handicap']); ?>
                </div>
            </div>
        <?php
        }
        echo '</div>';
    }

    /**
     * Render members in list layout
     */
    private function render_members_list(array $members, array $args): void
    {
        echo '<h3>Members</h3><ul class="pwg-members-list">';
        foreach ($members as $member) {
        ?>
            <li class="pwg-member-item">
                <?php if ($args['show_avatar']): ?>
                    <div class="pwg-member-avatar"><?php echo $member['avatar']; ?></div>
                <?php endif; ?>
                <div class="pwg-member-details">
                    <span class="pwg-member-name">
                        <a href="<?php echo esc_url($member['profile_url']); ?>">
                            <?php echo esc_html($member['name']); ?>
                        </a>
                    </span>
                    <span class="pwg-member-handicap">
                        (<?php echo $member['handicap'] === '999' ? 'N/A' : esc_html($member['handicap']); ?>)
                    </span>
                </div>
            </li>
        <?php
        }
        echo '</ul>';
    }

    /**
     * Static method to get member count for a club
     */
    public static function get_member_count(int $club_id): int
    {
        return count(get_users([
            'meta_key' => 'homeclub',
            'meta_value' => $club_id,
            'meta_type' => 'NUMERIC',
            'count_total' => true,
            'fields' => 'ID'
        ]));
    }

    /**
     * Generates an HTML form for creating/editing a golf club
     * 
     * @param array|null $club_data Existing club data if editing
     * @return string HTML form
     */
    public static function generate_form(?array $club_data = null): string
    {
        // Get empty defaults if no club data provided
        $data = $club_data ?? [
            'id' => 0,
            'name' => '',
            'description' => '',
            'address' => [
                'address1' => '',
                'address2' => '',
                'town_city' => '',
                'county' => '',
                'country' => '',
                'postcode' => '',
                'website' => '',
                'gps' => ''
            ],
            'contact' => [
                'phone' => '',
                'email' => '',
                'facebook' => '',
                'twitter' => ''
            ],
            'hole_count' => 18
        ];

        ob_start();
        ?>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="golf-club-form">
            <?php wp_nonce_field('save_golf_club', 'golf_club_nonce'); ?>

            <?php if ($data['id']): ?>
                <input type="hidden" name="club_id" value="<?php echo esc_attr($data['id']); ?>">
            <?php endif; ?>
            <input type="hidden" name="action" value="save_golf_club">
            <input type="hidden" name="hole_count" value="<?php echo esc_attr($data['hole_count']); ?>">

            <fieldset>
                <legend>Club Details</legend>

                <label for="club_name">Club Name:</label>
                <input type="text"
                    id="club_name"
                    name="club_name"
                    value="<?php echo esc_attr($data['name']); ?>"
                    required>

                <label for="club_about">About the Club:</label>
                <textarea id="club_about"
                    name="club_about"
                    rows="5"><?php echo esc_textarea($data['description']); ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Address</legend>

                <label for="address_1">Address Line 1:</label>
                <input type="text"
                    id="address_1"
                    name="address_1"
                    value="<?php echo esc_attr($data['address']['address1']); ?>"
                    required>

                <!-- Additional address fields... -->
                <label for="address_2">Address Line 2:</label>
                <input type="text"
                    id="address_2"
                    name="address_2"
                    value="<?php echo esc_attr($data['address']['address2']); ?>">


                <label for="county">County:</label>
                <input type="text"
                    id="county"
                    name="county"
                    value="<?php echo esc_attr($data['address']['county']); ?>">

                <label for="address_1">Countrty:</label>
                <input type="text"
                    id="country"
                    name="country"
                    value="<?php echo esc_attr($data['address']['country']); ?>"
                    required>


                <label for="postcode">Postcode:</label>
                <input type="text"
                    id="postcode"
                    name="postcode"
                    value="<?php echo esc_attr($data['address']['postcode']); ?>"
                    required>

                <label for="website">Website:</label>
                <input type="website"
                    id="website"
                    name="website"
                    value="<?php echo esc_attr($data['address']['website']); ?>">

                <label for="gps">GPS:</label>
                <input type="text"
                    id="gps"
                    name="gps"
                    value="<?php echo esc_attr($data['address']['gps']); ?>">

            </fieldset>

            <fieldset>
                <legend>Contact Information</legend>

                <label for="phone">Phone:</label>
                <input type="tel"
                    id="phone"
                    name="phone"
                    value="<?php echo esc_attr($data['contact']['phone']); ?>">

                <label for="email">Phone:</label>
                <input type="email"
                    id="email"
                    name="email"
                    value="<?php echo esc_attr($data['contact']['email']); ?>"
                    required>

                <label for="facebook">Facebook:</label>
                <input type="website"
                    id="facebook"
                    name="facebook"
                    value="<?php echo esc_attr($data['contact']['facebook']); ?>"
                    required>

                <label for="twitter">Twitter:</label>
                <input type="website"
                    id="twitter"
                    name="twitter"
                    value="<?php echo esc_attr($data['contact']['twitter']); ?>"
                    required>

                <!-- Additional contact fields... -->
            </fieldset>

            <button type="submit" class="button button-primary">
                <?php echo $data['id'] ? 'Update Golf Club' : 'Create Golf Club'; ?>
            </button>
        </form>
<?php
        return ob_get_clean();
    }

    /**
     * Handles form submission and saves club data
     */
    public static function handle_submission(): void
    {
        // Verify nonce and capabilities
        if (
            !isset($_POST['golf_club_nonce']) ||
            !wp_verify_nonce($_POST['golf_club_nonce'], 'save_golf_club') ||
            !current_user_can('edit_posts')
        ) {
            wp_die('Security check failed');
        }

        // Prepare club data from form submission
        $club_data = [
            'id' => isset($_POST['club_id']) ? intval($_POST['club_id']) : null,
            'club_name' => sanitize_text_field($_POST['club_name']),
            'description' => sanitize_textarea_field($_POST['club_about']),
            'address' => [
                'address1' => sanitize_text_field($_POST['address_1']),
                'address2' => sanitize_text_field($_POST['address_2']),
                'town_city' => sanitize_text_field($_POST['town_city']),
                'county' => sanitize_text_field($_POST['county']),
                'country' => sanitize_text_field($_POST['country']),
                'postcode' => sanitize_text_field($_POST['postcode']),
                'gps' => sanitize_text_field($_POST['gps']),
                'website' => esc_url_raw($_POST['website'])
            ],
            'contact' => [
                'phone' => sanitize_text_field($_POST['phone']),
                'email' => sanitize_email($_POST['email']),
                'facebook' => esc_url_raw($_POST['facebook']),
                'twitter' => esc_url_raw($_POST['twitter'])
            ]
        ];

        // Save club using existing static method
        // $result = PWG_GolfClub::save_club($club_data);

        // Quick create club
        // Get the entity manager instance
        $entityManager = PWG_EntityManager::getInstance();
        $result = $entityManager->createQuickClubCourse($club_data);


        if (is_wp_error($result)) {
            // Handle error
            wp_die($result->get_error_message());
        }

        $success_meesage = [
            'page' => 'golf-clubs',
            'updated' => 'true',
            'club_id' => $result
        ];

        // Redirect with success message
        wp_redirect(add_query_arg($result, admin_url('admin.php')));
        exit;
    }

    /**
     * Shortcode handler for displaying the club form
     */
    public static function shortcode_handler($atts): string
    {
        // Parse attributes
        $atts = shortcode_atts([
            'club_id' => 0
        ], $atts);

        // Get club data if editing
        $club_data = null;
        if ($atts['club_id']) {
            $club_data = PWG_GolfClub::get_club_data(intval($atts['club_id']));
            if (!$club_data) {
                return '<p>Club not found.</p>';
            }
        }

        // Check permissions
        if (!current_user_can('edit_posts')) {
            return '<p>You do not have permission to edit clubs.</p>';
        }

        // Return the form
        return self::generate_form($club_data);
    }
}
