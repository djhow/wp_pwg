<?php

class PWG_GolfCourse
{
    private $id;
    private $course_data;

    // Standard tee configuration - could be moved to a configuration file
    private static $tee_config = [
        'blue' => ['color' => '#000080', 'name' => 'Championship'],
        'white' => ['color' => '#FFFFFF', 'name' => 'Medal'],
        'yellow' => ['color' => '#FFD700', 'name' => 'Club'],
        'red' => ['color' => '#FF0000', 'name' => 'Forward']
    ];

    /**
     * Constructor only accepts an ID and does minimal initialization
     */
    public function __construct(?int $id = null)
    {
        if ($id) {
            $this->id = $id;
            $post = get_post($id);
            if (!$post || $post->post_type !== 'golfcourse') {
                throw new Exception('Invalid golf course ID');
            }
        }
    }

    /**
     * Get basic course data without instantiating an object
     */
    public static function get_course_data(int $course_id): array|false
    {
        global $wpdb;

        // Verify post exists and is published
        $post = get_post($course_id);
        if (!$post || $post->post_type !== 'golfcourse' || $post->post_status !== 'publish') {
            return false;
        }

        // Get course metadata from custom table
        $course_meta = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM wp_golf_courses WHERE course_ID = %d",
            $course_id
        ), ARRAY_A);

        if (!$course_meta) {
            return false;
        }

        // Build stats for each tee
        $tee_stats = [];
        foreach (array_keys(self::$tee_config) as $tee) {
            $tee_stats[$tee] = [
                'yards' => $course_meta["{$tee}_yards_total"],
                'par' => $course_meta["{$tee}_par_total"],
                'cr' => $course_meta["cr_{$tee}"],
                'sr' => $course_meta["sr_{$tee}"]
            ];
        }

        return [
            'id' => $course_id,
            'name' => $post->post_title,
            'description' => $post->post_content,
            'club_id' => $course_meta['club_ID'],
            'tee_stats' => $tee_stats
        ];
    }

    /**
     * Get course holes data efficiently
     */
    public static function get_course_holes(int $course_id): array
    {
        global $wpdb;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM wp_holes 
             WHERE course_ID = %d 
             ORDER BY number",
            $course_id
        ), ARRAY_A);
    }

    /**
     * Static method to render a scorecard without instantiating an object
     */
    public static function render_scorecard(int $course_id, array $options = []): string
    {
        $course_data = self::get_course_data($course_id);
        if (!$course_data) {
            return '<p>Course not found</p>';
        }

        $holes = self::get_course_holes($course_id);
        if (empty($holes)) {
            return '<p>No hole data available</p>';
        }

        // Default options
        $defaults = [
            'show_hole_names' => true,
            'show_tees' => ['blue', 'white', 'yellow', 'red'],
            'show_si' => true,
            'show_totals' => true
        ];
        $options = array_merge($defaults, $options);

        ob_start();
?>
        <div class="golf-scorecard">
            <!-- Course Statistics -->
            <div class="course-stats">
                <h3><?php echo esc_html($course_data['name']); ?> - Course Statistics</h3>
                <table class="stats-table">
                    <thead>
                        <tr>
                            <th>Tees</th>
                            <th>Par</th>
                            <th>Yards</th>
                            <th>CR</th>
                            <th>SR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($options['show_tees'] as $tee):
                            $stats = $course_data['tee_stats'][$tee];
                        ?>
                            <tr class="tee-<?php echo esc_attr($tee); ?>">
                                <td><?php echo esc_html(self::$tee_config[$tee]['name']); ?></td>
                                <td><?php echo esc_html($stats['par']); ?></td>
                                <td><?php echo esc_html($stats['yards']); ?></td>
                                <td><?php echo esc_html($stats['cr']); ?></td>
                                <td><?php echo esc_html($stats['sr']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Front Nine -->
            <?php self::render_scorecard_section($holes, 1, 9, $options); ?>

            <!-- Back Nine -->
            <?php self::render_scorecard_section($holes, 10, 18, $options); ?>
        </div>
    <?php
        return ob_get_clean();
    }

    /**
     * Helper method to render a section of the scorecard
     */
    private static function render_scorecard_section(array $holes, int $start, int $end, array $options): void
    {
        $section_holes = array_filter($holes, function ($hole) use ($start, $end) {
            return $hole['number'] >= $start && $hole['number'] <= $end;
        });

        if (empty($section_holes)) {
            return;
        }

        $totals = [];
        foreach ($options['show_tees'] as $tee) {
            $totals[$tee] = ['yards' => 0, 'par' => 0];
        }
    ?>
        <table class="scorecard-section">
            <thead>
                <tr>
                    <th>Hole</th>
                    <?php if ($options['show_hole_names']): ?>
                        <th>Name</th>
                    <?php endif; ?>
                    <?php foreach ($options['show_tees'] as $tee): ?>
                        <th class="tee-<?php echo esc_attr($tee); ?>">Yards</th>
                        <th class="tee-<?php echo esc_attr($tee); ?>">Par</th>
                        <?php if ($options['show_si']): ?>
                            <th class="tee-<?php echo esc_attr($tee); ?>">SI</th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($section_holes as $hole): ?>
                    <tr>
                        <td><?php echo esc_html($hole['number']); ?></td>
                        <?php if ($options['show_hole_names']): ?>
                            <td><?php echo esc_html($hole['name']); ?></td>
                        <?php endif; ?>
                        <?php foreach ($options['show_tees'] as $tee):
                            $totals[$tee]['yards'] += $hole["{$tee}_yards"];
                            $totals[$tee]['par'] += $hole["{$tee}_par"];
                        ?>
                            <td class="tee-<?php echo esc_attr($tee); ?>"><?php echo esc_html($hole["{$tee}_yards"]); ?></td>
                            <td class="tee-<?php echo esc_attr($tee); ?>"><?php echo esc_html($hole["{$tee}_par"]); ?></td>
                            <?php if ($options['show_si']): ?>
                                <td class="tee-<?php echo esc_attr($tee); ?>"><?php echo esc_html($hole["si_{$tee}"]); ?></td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>

                <?php if ($options['show_totals']): ?>
                    <tr class="totals">
                        <td><?php echo $start === 1 ? 'Out' : 'In'; ?></td>
                        <?php if ($options['show_hole_names']): ?>
                            <td></td>
                        <?php endif; ?>
                        <?php foreach ($options['show_tees'] as $tee): ?>
                            <td class="tee-<?php echo esc_attr($tee); ?>"><?php echo esc_html($totals[$tee]['yards']); ?></td>
                            <td class="tee-<?php echo esc_attr($tee); ?>"><?php echo esc_html($totals[$tee]['par']); ?></td>
                            <?php if ($options['show_si']): ?>
                                <td class="tee-<?php echo esc_attr($tee); ?>"></td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
<?php
    }

    /**
     * Save course data efficiently
     */
    public static function save_course(array $data): int|WP_Error
    {
        try {
            global $wpdb;

            // Validate required fields
            $required = ['name', 'club_id'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Missing required field: {$field}");
                }
            }

            // Create/update WordPress post
            $post_data = [
                'post_type' => 'golfcourse',
                'post_status' => 'publish',
                'post_title' => sanitize_text_field($data['name']),
                'post_content' => wp_kses_post($data['description'] ?? ''),
            ];

            if (!empty($data['id'])) {
                $post_data['ID'] = $data['id'];
                $course_id = wp_update_post($post_data);
            } else {
                $course_id = wp_insert_post($post_data);
            }

            if (is_wp_error($course_id)) {
                return $course_id;
            }

            // Prepare course metadata
            $course_meta = [
                'course_ID' => $course_id,
                'club_ID' => $data['club_id']
            ];

            // Add tee statistics
            foreach (array_keys(self::$tee_config) as $tee) {
                $course_meta["{$tee}_yards_total"] = intval($data['tee_stats'][$tee]['yards'] ?? 0);
                $course_meta["{$tee}_par_total"] = intval($data['tee_stats'][$tee]['par'] ?? 0);
                $course_meta["cr_{$tee}"] = floatval($data['tee_stats'][$tee]['cr'] ?? 0);
                $course_meta["sr_{$tee}"] = floatval($data['tee_stats'][$tee]['sr'] ?? 0);
            }

            // Save to custom table
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT course_ID FROM wp_golf_courses WHERE course_ID = %d",
                $course_id
            ));

            if ($exists) {
                $wpdb->update('wp_golf_courses', $course_meta, ['course_ID' => $course_id]);
            } else {
                $wpdb->insert('wp_golf_courses', $course_meta);
            }

            // Save holes if provided
            if (!empty($data['holes'])) {
                self::save_holes($course_id, $data['holes']);
            }

            return $course_id;
        } catch (Exception $e) {
            return new WP_Error('course_save_failed', $e->getMessage());
        }
    }

    /**
     * Helper method to save hole data
     */
    private static function save_holes(int $course_id, array $holes): void
    {
        global $wpdb;

        foreach ($holes as $hole) {
            if (empty($hole['number'])) {
                continue;
            }

            $hole_data = [
                'course_ID' => $course_id,
                'number' => $hole['number'],
                'name' => $hole['name'] ?? '',
                'pro_tip' => $hole['pro_tip'] ?? ''
            ];

            // Add tee-specific data
            foreach (array_keys(self::$tee_config) as $tee) {
                $hole_data["{$tee}_yards"] = intval($hole["{$tee}_yards"] ?? 0);
                $hole_data["{$tee}_par"] = intval($hole["{$tee}_par"] ?? 0);
                $hole_data["si_{$tee}"] = intval($hole["si_{$tee}"] ?? 0);
            }

            // Update or insert
            $existing = $wpdb->get_var($wpdb->prepare(
                "SELECT hole_ID FROM wp_holes WHERE course_ID = %d AND number = %d",
                $course_id,
                $hole['number']
            ));

            if ($existing) {
                $wpdb->update('wp_holes', $hole_data, ['hole_ID' => $existing]);
            } else {
                $wpdb->insert('wp_holes', $hole_data);
            }
        }
    }

    // Instance methods for when we need full object functionality
    public function load_course_data(): void
    {
        if (!$this->id) {
            throw new Exception('No course ID set');
        }
        $this->course_data = self::get_course_data($this->id);
        if (!$this->course_data) {
            throw new Exception('Course data not found');
        }
    }

    public function update(array $data): int|WP_Error
    {
        $data['id'] = $this->id;
        return self::save_course($data);
    }
}
