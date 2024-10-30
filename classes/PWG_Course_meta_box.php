<?php

class PWG_Course_Meta_Box
{
    private $tees = [
        'blue' => ['color' => '#000080', 'name' => 'Championship'],
        'white' => ['color' => '#FFFFFF', 'name' => 'Medal'],
        'yellow' => ['color' => '#FFD700', 'name' => 'Club'],
        'red' => ['color' => '#FF0000', 'name' => 'Forward']
    ];

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_course_meta_boxes']);
        add_action('save_post_golfcourse', [$this, 'save_course_meta'], 10, 2);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    public function enqueue_admin_scripts($hook)
    {
        if (!in_array($hook, ['post.php', 'post-new.php'])) {
            return;
        }

        global $post;
        if ($post && $post->post_type === 'golfcourse') {
            wp_enqueue_script('pwg-course-admin', plugins_url('/assets/js/course-admin.js', dirname(__FILE__)), ['jquery'], '1.0', true);
            wp_add_inline_script('pwg-course-admin', "
                jQuery(document).ready(function($) {
                    $('.pwg-tabs a').on('click', function(e) {
                        e.preventDefault();
                        var target = $(this).attr('href');
                        
                        // Update tabs
                        $('.pwg-tabs li').removeClass('active');
                        $(this).parent().addClass('active');
                        
                        // Update content
                        $('.pwg-tab-content').removeClass('active');
                        $(target).addClass('active');
                    });
                });
            ");

            wp_add_inline_style('pwg-course-admin', "
                .pwg-scorecard-tabs { margin-top: 15px; }
                .pwg-tabs { display: flex; border-bottom: 1px solid #ccc; margin: 0; padding: 0; }
                .pwg-tabs li { margin: 0; padding: 0; list-style: none; }
                .pwg-tabs li a { 
                    display: block; 
                    padding: 10px 15px; 
                    text-decoration: none; 
                    border: 1px solid transparent;
                    margin-bottom: -1px;
                    color: #23282d;
                }
                .pwg-tabs li.active a { 
                    border-color: #ccc #ccc #fff;
                    background: #fff;
                }
                .pwg-tab-content { display: none; padding: 15px; border: 1px solid #ccc; border-top: 0; }
                .pwg-tab-content.active { display: block; }
                .hole-table { width: 100%; border-collapse: collapse; }
                .hole-table th, .hole-table td { padding: 5px; border: 1px solid #ddd; }
                .hole-table input[type='number'] { width: 60px; }
                .hole-table input[type='text'] { width: 100%; }
            ");
        }
    }

    public function add_course_meta_boxes()
    {
        add_meta_box(
            'pwg_course_scorecard',
            'Course Scorecard',
            [$this, 'render_scorecard_box'],
            'golfcourse',
            'normal',
            'high'
        );

        add_meta_box(
            'pwg_course_ratings',
            'Course Ratings',
            [$this, 'render_course_ratings_box'],
            'golfcourse',
            'side',
            'default'
        );
    }

    public function render_course_ratings_box($post)
    {
        wp_nonce_field('pwg_course_meta_box', 'pwg_course_meta_box_nonce');

        $course_stats = get_post_meta($post->ID, '_course_stats', true);
        if (!is_array($course_stats)) {
            $course_stats = [];
        }

?>
        <div class="pwg-course-ratings">
            <?php foreach ($this->tees as $tee => $tee_info):
                $stats = $course_stats[$tee] ?? ['cr' => '', 'sr' => ''];
            ?>
                <div class="tee-ratings" style="border-left: 4px solid <?php echo esc_attr($tee_info['color']); ?>; padding-left: 8px; margin-bottom: 15px;">
                    <h4><?php echo esc_html($tee_info['name']); ?> Tees</h4>
                    <p>
                        <label>Course Rating:</label>
                        <input type="number" step="0.1"
                            name="course_stats[<?php echo $tee; ?>][cr]"
                            value="<?php echo esc_attr($stats['cr']); ?>"
                            class="small-text">
                    </p>
                    <p>
                        <label>Slope Rating:</label>
                        <input type="number"
                            name="course_stats[<?php echo $tee; ?>][sr]"
                            value="<?php echo esc_attr($stats['sr']); ?>"
                            class="small-text">
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php
    }

    public function render_scorecard_box($post)
    {
        $holes = get_post_meta($post->ID, '_course_holes', true);
        if (!is_array($holes)) {
            $holes = [];
        }

    ?>
        <div class="pwg-scorecard-tabs">
            <ul class="pwg-tabs">
                <li class="active"><a href="#front-nine">Front Nine</a></li>
                <li><a href="#back-nine">Back Nine</a></li>
            </ul>

            <div id="front-nine" class="pwg-tab-content active">
                <?php $this->render_nine_holes(1, 9, $holes); ?>
            </div>

            <div id="back-nine" class="pwg-tab-content">
                <?php $this->render_nine_holes(10, 18, $holes); ?>
            </div>
        </div>
    <?php
    }

    private function render_nine_holes($start, $end, $holes)
    {
    ?>
        <table class="hole-table">
            <thead>
                <tr>
                    <th>Hole</th>
                    <th>Name</th>
                    <?php foreach ($this->tees as $tee => $tee_info): ?>
                        <th colspan="3" style="background-color: <?php echo esc_attr($tee_info['color']); ?>; color: <?php echo $tee === 'white' ? '#000' : '#fff'; ?>">
                            <?php echo esc_html($tee_info['name']); ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <?php foreach ($this->tees as $tee => $tee_info): ?>
                        <th>Yards</th>
                        <th>Par</th>
                        <th>SI</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = $start; $i <= $end; $i++):
                    $hole = isset($holes[$i - 1]) ? $holes[$i - 1] : [];
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <input type="text"
                                name="holes[<?php echo $i; ?>][name]"
                                value="<?php echo esc_attr($hole['name'] ?? ''); ?>">
                        </td>
                        <?php foreach ($this->tees as $tee => $tee_info): ?>
                            <td>
                                <input type="number"
                                    name="holes[<?php echo $i; ?>][<?php echo $tee; ?>_yards]"
                                    value="<?php echo esc_attr($hole["{$tee}_yards"] ?? ''); ?>"
                                    min="0" max="999">
                            </td>
                            <td>
                                <input type="number"
                                    name="holes[<?php echo $i; ?>][<?php echo $tee; ?>_par]"
                                    value="<?php echo esc_attr($hole["{$tee}_par"] ?? ''); ?>"
                                    min="3" max="6">
                            </td>
                            <td>
                                <input type="number"
                                    name="holes[<?php echo $i; ?>][si_<?php echo $tee; ?>]"
                                    value="<?php echo esc_attr($hole["si_{$tee}"] ?? ''); ?>"
                                    min="1" max="18">
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
<?php
    }

    public function save_course_meta($post_id, $post)
    {
        // Security checks
        if (
            !isset($_POST['pwg_course_meta_box_nonce']) ||
            !wp_verify_nonce($_POST['pwg_course_meta_box_nonce'], 'pwg_course_meta_box') ||
            defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ||
            !current_user_can('edit_post', $post_id) ||
            $post->post_type !== 'golfcourse'
        ) {
            return;
        }

        // Save course statistics
        if (isset($_POST['course_stats'])) {
            $stats = [];
            foreach ($this->tees as $tee => $tee_info) {
                if (isset($_POST['course_stats'][$tee])) {
                    $stats[$tee] = [
                        'cr' => (float) $_POST['course_stats'][$tee]['cr'],
                        'sr' => (int) $_POST['course_stats'][$tee]['sr']
                    ];
                }
            }
            update_post_meta($post_id, '_course_stats', $stats);
        }

        // Save hole data
        if (isset($_POST['holes'])) {
            $holes = [];
            for ($i = 1; $i <= 18; $i++) {
                if (isset($_POST['holes'][$i])) {
                    $hole_data = $_POST['holes'][$i];
                    $hole = [
                        'number' => $i,
                        'name' => sanitize_text_field($hole_data['name'] ?? '')
                    ];

                    foreach ($this->tees as $tee => $tee_info) {
                        $hole["{$tee}_yards"] = absint($hole_data["{$tee}_yards"] ?? 0);
                        $hole["{$tee}_par"] = absint($hole_data["{$tee}_par"] ?? 0);
                        $hole["si_{$tee}"] = absint($hole_data["si_{$tee}"] ?? 0);
                    }

                    $holes[] = $hole;
                }
            }
            update_post_meta($post_id, '_course_holes', $holes);
        }
    }
}

// Initialize the meta box
new PWG_Course_Meta_Box();
