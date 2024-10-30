<?php

class PWG_EntityManager
{
    private static $instance = null;
    private $cache = [];

    // Private constructor for singleton pattern
    private function __construct() {}

    /**
     * Get singleton instance
     */
    public static function getInstance(): PWG_EntityManager
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Create a new golf club
     * 
     * @param array $clubData Club data
     * @return int|WP_Error Club ID or error
     */
    public function createClub(array $clubData): int|WP_Error
    {
        try {
            $result = PWG_GolfClub::save_club($clubData);
            if (!is_wp_error($result)) {
                // Clear any cached data for this club
                $this->clearCache('club', $result);
            }
            return $result;
        } catch (Exception $e) {
            return new WP_Error('club_creation_failed', $e->getMessage());
        }
    }

    /**
     * Create a new golf course
     * 
     * @param array $courseData Course data including club_id
     * @return int|WP_Error Course ID or error
     */
    public function createCourse(array $courseData): int|WP_Error
    {
        try {
            // Verify the club exists
            if (!$this->getClub($courseData['club_id'])) {
                return new WP_Error('invalid_club', 'Golf club not found');
            }

            $result = PWG_GolfCourse::save_course($courseData);
            if (!is_wp_error($result)) {
                // Clear related caches
                $this->clearCache('course', $result);
                $this->clearCache('club_courses', $courseData['club_id']);
            }
            return $result;
        } catch (Exception $e) {
            return new WP_Error('course_creation_failed', $e->getMessage());
        }
    }

    /**
     * Get a golf club by ID
     * 
     * @param int $clubId Club ID
     * @return array|false Club data or false if not found
     */
    public function getClub(int $clubId): array|false
    {
        $cacheKey = "club_{$clubId}";

        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $clubData = PWG_GolfClub::get_club_data($clubId);
        if ($clubData) {
            $this->cache[$cacheKey] = $clubData;
        }

        return $clubData;
    }

    /**
     * Get a golf course by ID
     * 
     * @param int $courseId Course ID
     * @return array|false Course data or false if not found
     */
    public function getCourse(int $courseId): array|false
    {
        $cacheKey = "course_{$courseId}";

        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $courseData = PWG_GolfCourse::get_course_data($courseId);
        if ($courseData) {
            $this->cache[$cacheKey] = $courseData;
        }

        return $courseData;
    }

    /**
     * Get all courses for a club
     * 
     * @param int $clubId Club ID
     * @return array Array of course data
     */
    public function getClubCourses(int $clubId): array
    {
        $cacheKey = "club_courses_{$clubId}";

        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $courses = PWG_GolfClub::get_club_courses($clubId);
        $this->cache[$cacheKey] = $courses;

        return $courses;
    }

    /**
     * Get course holes
     * 
     * @param int $courseId Course ID
     * @return array Array of hole data
     */
    public function getCourseHoles(int $courseId): array
    {
        $cacheKey = "course_holes_{$courseId}";

        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $holes = PWG_GolfCourse::get_course_holes($courseId);
        $this->cache[$cacheKey] = $holes;

        return $holes;
    }

    /**
     * Update a golf club
     * 
     * @param int $clubId Club ID
     * @param array $clubData Updated club data
     * @return int|WP_Error Club ID or error
     */
    public function updateClub(int $clubId, array $clubData): int|WP_Error
    {
        $clubData['id'] = $clubId;
        $result = PWG_GolfClub::save_club($clubData);

        if (!is_wp_error($result)) {
            $this->clearCache('club', $clubId);
        }

        return $result;
    }

    /**
     * Update a golf course
     * 
     * @param int $courseId Course ID
     * @param array $courseData Updated course data
     * @return int|WP_Error Course ID or error
     */
    public function updateCourse(int $courseId, array $courseData): int|WP_Error
    {
        $courseData['id'] = $courseId;
        $result = PWG_GolfCourse::save_course($courseData);

        if (!is_wp_error($result)) {
            $this->clearCache('course', $courseId);
            $this->clearCache('club_courses', $courseData['club_id']);
            $this->clearCache('course_holes', $courseId);
        }

        return $result;
    }

    /**
     * Delete a golf club and all its courses
     * 
     * @param int $clubId Club ID
     * @return bool Success status
     */
    public function deleteClub(int $clubId): bool
    {
        try {
            global $wpdb;

            // Get all courses for this club
            $courses = $this->getClubCourses($clubId);

            // Start transaction
            $wpdb->query('START TRANSACTION');

            // Delete each course
            foreach ($courses as $course) {
                if (!$this->deleteCourse($course['course_ID'])) {
                    throw new Exception('Failed to delete course');
                }
            }

            // Delete club from WordPress posts
            $result = wp_delete_post($clubId, true);
            if (!$result) {
                throw new Exception('Failed to delete club post');
            }

            // Delete from custom table
            $wpdb->delete('wp_golf_clubs', ['club_ID' => $clubId]);

            // Clear caches
            $this->clearCache('club', $clubId);
            $this->clearCache('club_courses', $clubId);

            $wpdb->query('COMMIT');
            return true;
        } catch (Exception $e) {
            $wpdb->query('ROLLBACK');
            return false;
        }
    }

    /**
     * Delete a golf course and its holes
     * 
     * @param int $courseId Course ID
     * @return bool Success status
     */
    public function deleteCourse(int $courseId): bool
    {
        try {
            global $wpdb;

            // Start transaction
            $wpdb->query('START TRANSACTION');

            // Delete holes
            $wpdb->delete('wp_holes', ['course_ID' => $courseId]);

            // Delete course from WordPress posts
            $result = wp_delete_post($courseId, true);
            if (!$result) {
                throw new Exception('Failed to delete course post');
            }

            // Delete from custom table
            $wpdb->delete('wp_golf_courses', ['course_ID' => $courseId]);

            // Clear caches
            $this->clearCache('course', $courseId);
            $this->clearCache('course_holes', $courseId);

            $wpdb->query('COMMIT');
            return true;
        } catch (Exception $e) {
            $wpdb->query('ROLLBACK');
            return false;
        }
    }

    /**
     * Clear cached data
     * 
     * @param string $type Cache type (club, course, club_courses, course_holes)
     * @param int $id Entity ID
     */
    private function clearCache(string $type, int $id): void
    {
        $cacheKey = "{$type}_{$id}";
        unset($this->cache[$cacheKey]);
    }

    public function createQuickClubCourse(array $quickData): array|WP_Error
    {
        try {
            error_log('Starting createQuickClubCourse...');

            // Normalize the input data structure
            $normalizedData = $this->normalizeInputData($quickData);
            error_log('Normalized data: ' . print_r($normalizedData, true));

            // Validate required fields
            if (!isset($normalizedData['club_name']) || trim($normalizedData['club_name']) === '') {
                return new WP_Error('missing_club_name', 'Club name is required');
            }

            if (!isset($normalizedData['postcode']) || trim($normalizedData['postcode']) === '') {
                return new WP_Error('missing_postcode', 'Postcode is required');
            }

            // Set default hole count
            $holeCount = intval($normalizedData['hole_count'] ?? 18);
            if (!in_array($holeCount, [9, 18])) {
                return new WP_Error('invalid_hole_count', 'Invalid hole count. Must be 9 or 18.');
            }

            // Start transaction
            global $wpdb;
            $wpdb->query('START TRANSACTION');

            // Prepare club data
            $clubData = [
                'name' => sanitize_text_field($normalizedData['club_name']),
                'description' => sanitize_textarea_field($normalizedData['description'] ?? ''),
                'postcode' => sanitize_text_field($normalizedData['postcode']),
                'address1' => sanitize_text_field($normalizedData['address1'] ?? ''),
                'address2' => sanitize_text_field($normalizedData['address2'] ?? ''),
                'town_city' => sanitize_text_field($normalizedData['town_city'] ?? ''),
                'county' => sanitize_text_field($normalizedData['county'] ?? ''),
                'country' => sanitize_text_field($normalizedData['country'] ?? ''),
                'website' => esc_url_raw($normalizedData['website'] ?? ''),
                'gps' => sanitize_text_field($normalizedData['gps'] ?? ''),
                'phone' => sanitize_text_field($normalizedData['phone'] ?? ''),
                'email' => sanitize_email($normalizedData['email'] ?? ''),
                'facebook' => esc_url_raw($normalizedData['facebook'] ?? ''),
                'twitter' => esc_url_raw($normalizedData['twitter'] ?? '')
            ];

            error_log('Creating club with data: ' . print_r($clubData, true));

            // Create club
            $clubId = $this->createClub($clubData);
            if (is_wp_error($clubId)) {
                $wpdb->query('ROLLBACK');
                return $clubId;
            }

            // Create course
            $courseData = [
                'name' => sanitize_text_field($normalizedData['course_name'] ?? $normalizedData['club_name']),
                'club_id' => $clubId,
                'description' => sanitize_textarea_field($normalizedData['description'] ?? ''),
                'tee_stats' => [
                    'white' => [
                        'yards' => $holeCount === 18 ? 6000 : 3000,
                        'par' => $holeCount === 18 ? 72 : 36,
                        'cr' => 72.0,
                        'sr' => 125
                    ]
                ]
            ];

            error_log('Creating course with data: ' . print_r($courseData, true));

            $courseId = $this->createCourse($courseData);
            if (is_wp_error($courseId)) {
                $wpdb->query('ROLLBACK');
                return $courseId;
            }

            // Create holes
            $defaultHoleData = $this->generateDefaultHoles($holeCount);
            foreach ($defaultHoleData as $hole) {
                $hole['course_ID'] = $courseId;
                $result = $wpdb->insert('wp_holes', $hole);
                if ($result === false) {
                    $wpdb->query('ROLLBACK');
                    return new WP_Error(
                        'hole_creation_failed',
                        "Failed to create hole {$hole['number']}: " . $wpdb->last_error
                    );
                }
            }

            // If we got here, everything worked
            $wpdb->query('COMMIT');

            // Clear caches
            $this->clearCache('club', $clubId);
            $this->clearCache('course', $courseId);
            $this->clearCache('club_courses', $clubId);
            $this->clearCache('course_holes', $courseId);

            return [
                'club_id' => $clubId,
                'course_id' => $courseId,
                'message' => 'Club and course created successfully.'
            ];
        } catch (Exception $e) {
            error_log('Exception occurred: ' . $e->getMessage());
            if (isset($wpdb)) {
                $wpdb->query('ROLLBACK');
            }
            return new WP_Error('creation_failed', $e->getMessage());
        }
    }

    /**
     * Normalize input data structure
     * 
     * @param array $inputData Raw input data
     * @return array Normalized data
     */
    private function normalizeInputData(array $inputData): array
    {
        $normalized = [];

        // Debug the input data
        error_log('Input data being normalized: ' . print_r($inputData, true));

        // Basic fields
        $normalized['club_name'] = trim($inputData['club_name'] ?? '');
        $normalized['description'] = trim($inputData['description'] ?? '');
        $normalized['hole_count'] = $inputData['hole_count'] ?? 18;

        // Extract postcode - check both locations
        if (isset($inputData['address']['postcode'])) {
            $normalized['postcode'] = trim($inputData['address']['postcode']);
            error_log('Found postcode in address array: ' . $normalized['postcode']);
        } elseif (isset($inputData['postcode'])) {
            $normalized['postcode'] = trim($inputData['postcode']);
            error_log('Found postcode in top level: ' . $normalized['postcode']);
        }

        // Address fields
        if (isset($inputData['address']) && is_array($inputData['address'])) {
            foreach ($inputData['address'] as $key => $value) {
                if ($key !== 'postcode') { // Skip postcode as we handled it above
                    $normalized[$key] = trim($value);
                }
            }
        }

        // Contact fields
        if (isset($inputData['contact']) && is_array($inputData['contact'])) {
            foreach ($inputData['contact'] as $key => $value) {
                $normalized[$key] = trim($value);
            }
        }

        // Debug the normalized output
        error_log('Normalized data: ' . print_r($normalized, true));

        return $normalized;
    }

    /**
     * Generate default hole data based on typical course layout
     * 
     * @param int $holeCount Number of holes (9 or 18)
     * @return array Array of hole data
     */
    private function generateDefaultHoles(int $holeCount): array
    {
        $holes = [];
        $defaultPars = [4, 4, 4, 3, 5, 4, 4, 3, 5]; // Typical 9-hole par configuration

        for ($i = 1; $i <= $holeCount; $i++) {
            $parIndex = ($i - 1) % 9;
            $defaultPar = $defaultPars[$parIndex];
            $defaultYards = $this->estimateYardage($defaultPar);

            $holes[] = [
                'number' => $i,
                'name' => "Hole {$i}",
                'white_yards' => $defaultYards,
                'white_par' => $defaultPar,
                'si_white' => $i, // Basic stroke index
                'yellow_yards' => $defaultYards - 20,
                'yellow_par' => $defaultPar,
                'si_yellow' => $i,
                'red_yards' => $defaultYards - 40,
                'red_par' => $defaultPar,
                'si_red' => $i,
                'pro_tip' => ''
            ];
        }

        return $holes;
    }

    /**
     * Estimate yardage based on par
     * 
     * @param int $par Hole par
     * @return int Estimated yardage
     */
    private function estimateYardage(int $par): int
    {
        switch ($par) {
            case 3:
                return 165;
            case 4:
                return 380;
            case 5:
                return 520;
            default:
                return 400;
        }
    }

    public static function pretty_print($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}
