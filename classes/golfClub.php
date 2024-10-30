<?php
require_once(PWG_PLUGIN_DIR . '/classes/golfCourse.php');
class golfClub
{

    private $club_ID;
    private $course_ID;
    private $post_ID;
    private $created_by;
    private $date_created;
    private $club_name;
    private $about_club;
    private $address_1;
    private $address_2;
    private $town_city;
    private $county;
    private $country;
    private $postcode;
    private $gps;
    private $phone;
    private $email;
    private $facebook;
    private $twitter;
    private $social;
    private $club_courses;

    private $error_message;

    private $members;

    public function __construct($club = 0)
    {
        $this->processClub($club);
    }

    // public function jsonSerialize() {
    //     // return array to encode object
    //   }

    private function processClub($club)
    {
        if (is_object($club)) {
            $this->addClub($club);
        } else if (is_int($club) && $club > 0) {
            $this->getClub($club);
            $this->getCourses($club);
        }
    }

    public static function add_new_golfclub()
    {
        check_ajax_referer('new_club');

        if (isset($_POST['formData'])) {

            parse_str($_POST['formData'], $data);

            $clubname = sanitize_text_field($data['club_name']);
            $clubname = ucfirst($clubname);
            $homeclub = sanitize_text_field( $data['hmeclub'] );
            $aboutclub = sanitize_text_field($data['about_club']);
            $address1 = sanitize_text_field($data['address_1']);
            $address2 = sanitize_text_field($data['address_2']);
            $town = sanitize_text_field($data['town_city']);
            $postcode = sanitize_text_field($data['postcode']);
            $county = sanitize_text_field($data['county']);
            $country = sanitize_text_field($data['country']);
            $gps = sanitize_text_field($data['gps']);
            $phone = sanitize_text_field($data['phone']);
            $email = sanitize_email($data['email']);
            $facebook = sanitize_url($data['facebook']);
            $twitter = sanitize_url($data['twitter']);

            $args = [
                'post_title' =>  $clubname,
                'post_type' => 'golfclub',
                'post_status' => 'publish'
            ];
            
            $userID = get_current_user_id();
            $new_club_ID = wp_insert_post($args);
            If ($homeclub){
                update_user_meta( $userID, 'homeclub', $new_club_ID );
            }

            $golfclub = new golfClub();

            $golfclub->setCreatedBy( sanitize_text_field( $userID ));
            $golfclub->setPostID(sanitize_text_field( $new_club_ID ));
            $golfclub->setClubName(sanitize_text_field( $clubname ));
            $golfclub->setAboutClub(sanitize_text_field( $aboutclub ));
            $golfclub->setAddress1(sanitize_text_field( $address1 ));
            $golfclub->setAddress2(sanitize_text_field( $address2 ));
            $golfclub->setTownCity(sanitize_text_field( $town ));
            $golfclub->setPostcode(sanitize_text_field( $postcode ));
            $golfclub->setCounty(sanitize_text_field( $county ));
            $golfclub->setCountry(sanitize_text_field( $country ));
            $golfclub->setGps(sanitize_text_field( $gps ));
            $golfclub->setPhone(sanitize_text_field( $phone ));
            $golfclub->setEmail(sanitize_email( $email ));
            $golfclub->setFacebook(sanitize_url( $facebook ));
            $golfclub->setTwitter(sanitize_text_field( $twitter ));

            $insertClubID = $golfclub->insertClub();

            $returnArray = [
                'club_post_ID' => $new_club_ID,
                'golf_club_ID' => $insertClubID
                ];

            if ($insertClubID) {
                // we have a club_ID so create a golf course

                // need to return club_ID and course_ID
                wp_send_json( $golfclub->showClub());
            } else {

               wp_send_json(false);
            }
        }
        wp_die();
    }

    public function showAddNewClub()
    {
        require_once( PWG_PLUGIN_DIR . '/inc/club_html.php' );
    }

    function getCourses($club_ID)
    {
        global $wpdb;

        $course_sql = "SELECT `course_ID`
        FROM `wp_golf_courses` 
        WHERE club_ID = %d ";

        $course_IDs = $wpdb->get_results($wpdb->prepare($course_sql, $club_ID));
        //print_r($course_IDs);
        $course_array = [];
        if ($course_IDs) {
            foreach ($course_IDs as $course_ID) {
                $course = new golfCourse($course_ID->course_ID);
                $course_array[] = $course;

                //print_r($course);
            }
            $this->setClubCourses($course_array);
        }
    }

    function getClub($clubID = 0)
    {

        global $wpdb;
        global $post;

        if ($clubID > 0) {
            $club_ID = $clubID;
        } else {
            $club_ID = $post->ID;
        }

        $clubSQL = 'SELECT * FROM 
        `wp_golf_clubs` 
        WHERE `club_ID` = %d';

        $golfclub = $wpdb->get_row($wpdb->prepare($clubSQL, $club_ID));

        if (is_object($golfclub)) {
            $this->addClub($golfclub);
        }
    }

    public function insertClub()
    {
        global $wpdb;
        
        $args = [
            'created_by' => $this->getCreatedBy(),
            'post_ID' => $this->getPostID(),
            'club_name' => $this->getClubName(),
            'about_club' => $this->getAboutClub(),
            'address_1' => $this->getAddress1(),
            'address_2' => $this->getAddress2(),
            'town_city' => $this->getTownCity(),
            'county' => $this->getCounty(),
            'country' => $this->getCountry(),
            'postcode' => $this->getPostcode(),
            'gps' => $this->getGps(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'facebook' => $this->getFacebook(),
            'twitter' => $this->getTwitter()
        ];
        $formats = [
            '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'
        ];

        $results = $wpdb->insert('wp_golf_clubs', $args, $formats);
        if ($results) {
            return $wpdb->insert_id;
        } else {
            return false;
        }
    }

    public function updateClub($club_ID)

    {
        global $wpdb;
        $sql = "UPDATE `wp_golf_clubs` SET `club_name` = %s, `about_club` = %s, `address_1` = %s, `address_2` = %s, `city` = %s, `postcode` = %s, `gps` = %s, `phone` = %s, `email` = %s, `social` = %s WHERE `club_ID` = %d";
        $results = $wpdb->query(
            $wpdb->prepare(
                $sql,
                $this->club_name,
                $this->about_club,
                $this->address_1,
                $this->address_2,
                $this->town_city,
                $this->postcode,
                $this->gps,
                $this->phone,
                $this->email,
                $this->social,
                $club_ID
            )
        );
        if ($results) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteClub($club_ID)
    {
        global $wpdb;

        $select_courses_sql = "SELECT `course_ID` FROM `wp_golf_courses` WHERE `club_ID` = %s";

        $delete_holes_sql = "DELETE FROM `wp_holes` WHERE `course_ID` = %s";

        $delete_courses_sql = "DELETE FROM `wp_golf_courses` WHERE `course_ID` = %s";

        $delete_club_sql = "DELETE FROM `wp_golf_clubs` WHERE `club_ID` = %s";

        $club_ID = [$club_ID];



        // select all courses belonging to the club
        $courses = $wpdb->get_results($wpdb->prepare($select_courses_sql, $club_ID));
        $results = [];
        if ($courses) {
            // delete all holes with course_ID
            foreach ($courses as $course) {
                $results[] = $wpdb->query($wpdb->prepare($delete_holes_sql, [$course->course_ID]));
            }
            // delete all the courses
            foreach ($courses as $course) {
                $results[] = $wpdb->query($wpdb->prepare($delete_courses_sql, [$course->course_ID]));
            }

            $results[] = $wpdb->query($wpdb->prepare($delete_club_sql, $club_ID));
            return $results;
        } else {
            return false;
        }
    }

    public function addClub($golfclub)
    {
        $class_name = get_class($golfclub);
        if (is_object($golfclub)) {
            $this->setClubID($golfclub->club_ID);
            $this->setDateCreated($golfclub->date_created);
            $this->setClubName($golfclub->club_name);
            $this->setAboutClub($golfclub->about_club);
            $this->setAddress1($golfclub->address_1);
            $this->setAddress2($golfclub->address_2);
            $this->setTownCity($golfclub->city);
            $this->setPostcode($golfclub->postcode);
            $this->setGps($golfclub->gps);
            $this->setPhone($golfclub->phone);
            $this->setEmail($golfclub->email);
            $this->setSocial($golfclub->social);
            return true;
        } else {
            return false;
        }
    }

    public function show_course_scorecard()
    {
        $golfcourses = $this->getClubCourses();

        foreach ($golfcourses as $golfcourse) {
            $holes = $golfcourse->getHoles();

        ?>

            <table id="course_details">
                <tr>
                    <th colspan="10"><?php echo $golfcourse->getClubName();  ?> Details</th>
                </tr>
                <tr>
                    <th>Par</th>
                    <td class="white"><?php echo $golfcourse->getWhiteParTotal(); ?></td>
                    <td class="yellow"><?php echo $golfcourse->getYellowParTotal(); ?></td>
                    <td class="red"><?php echo $golfcourse->getRedParTotal(); ?></td>
                    <td class="blue"><?php echo $golfcourse->getBlueParTotal(); ?></td>
                </tr>
                <tr>
                    <th>Yards</th>
                    <td class="white"><?php echo $golfcourse->getWhiteYardsTotal(); ?></td>
                    <td class="yellow"><?php echo $golfcourse->getYellowYardsTotal(); ?></td>
                    <td class="red"><?php echo $golfcourse->getRedYardsTotal(); ?></td>
                    <td class="blue"><?php echo $golfcourse->getBlueYardsTotal(); ?></td>
                </tr>
                <tr>
                    <th></th>
                    <th>Course Rating</th>
                    <th>Slope Rating</th>
                    <th>Course Rating</th>
                    <th>Slope Rating</th>
                </tr>
                <tr>
                    <td></td>
                    <td class="white"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $golfcourse->getCrWhite() . '_'  ?>" name="<?php echo $golfcourse->getCrWhite() . '_'  ?>" value="<?php echo $golfcourse->getCrWhite(); ?>"><?php echo $golfcourse->getCrWhite(); ?></td>
                    <td class="yellow"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $golfcourse->getSrWhite() . '_'  ?>" name="<?php echo $golfcourse->getSrWhite() . '_'  ?>" value="<?php echo $golfcourse->getSrWhite(); ?>"><?php echo $golfcourse->getSrWhite(); ?></td>
                    <td class="red"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $golfcourse->getCrRed() . '_'  ?>" name="<?php echo $golfcourse->getCrRed() . '_'  ?>" value="<?php echo $golfcourse->getCrRed(); ?>"><?php echo $golfcourse->getCrRed(); ?></td>
                    <td class="blue"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $golfcourse->getSrRed() . '_'  ?>" name="<?php echo $golfcourse->getSrRed() . '_'  ?>" value="<?php echo $golfcourse->getSrRed(); ?>"><?php echo $golfcourse->getSrRed(); ?></td>
                </tr>
            </table>



        <?php
            $holes->build_table();
        }
    }

    public function show_edit_scorcard($course_ID = 0)
    {

        $golfcourses = $this->getClubCourses();

        $holesnames = 0;

        //$this->pretty_print($golfcourses);

        $columns_count = 0;



        foreach ($golfcourses as $course) {
            //$this->pretty_print($course->getClubID());
            $wy_total = 0;
            $yy_total = 0;
            $ry_total = 0;
            $by_total = 0;
        ?>

            <table id="course_details">
                <tr>
                    <th colspan="10"><?php echo $course->getClubName();  ?> Details</th>
                </tr>
                <tr>
                    <th class="white">Par</th>
                    <th class="yellow">Par</th>
                    <th class="red">Par</th>
                    <th class="blue">Par</th>

                </tr>
                <tr>
                    <td class="white"><input type="hidden" maxlength="2" style="width: 30px;" id="<?php echo $course->getWhiteParTotal() . '_' . $course->hole_ID  ?>" name="<?php echo $course->getWhiteParTotal() . '_' . $course->getCourseID()  ?>" value="<?php echo $course->getWhiteParTotal(); ?>"><?php echo $course->getWhiteParTotal(); ?></td>
                    <td class="yellow"><input type="hidden" maxlength="2" style="width: 30px;" id="<?php echo $course->getYellowParTotal() . '_' . $course->hole_ID  ?>" name="<?php echo $course->getYellowParTotal() . '_' . $course->holes->hole_ID  ?>" value="<?php echo $course->getYellowParTotal(); ?>"><?php echo $course->getYellowParTotal(); ?></td>
                    <td class="red"><input type="hidden" maxlength="2" style="width: 30px;" id="<?php echo $course->getRedParTotal() . '_' . $course->hole_ID  ?>" name="<?php echo $course->red_par_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->red_par_total; ?>"><?php echo $course->getRedParTotal(); ?></td>
                    <td class="blue"><input type="hidden" maxlength="2" style="width: 30px;" id="<?php echo $course->getBlueParTotal() . '_' . $course->hole_ID  ?>" name="<?php echo $course->red_par_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->red_par_total; ?>"><?php echo $course->getBlueParTotal(); ?></td>

                </tr>
                <tr>
                    <th class="white">Yds</th>
                    <th class="yellow">Yds</th>
                    <th class="red">Yds</th>
                    <th class="blue">Yds</th>

                </tr>
                <tr>
                    <td class="white"><input type="hidden" maxlength="4" style="width: 60px;" id="<?php echo $course->getWhiteYardsTotal() . '_' . $course->hole_ID  ?>" name="<?php echo $course->getWhiteYardsTotal() . '_' . $course->hole_ID  ?>" value="<?php echo $course->getWhiteYardsTotal(); ?>"><?php echo $course->getWhiteYardsTotal(); ?></td>
                    <td class="yellow"><input type="hidden" maxlength="4" style="width: 60px;" id="<?php echo $course->getYellowYardsTotal() . '_' . $course->hole_ID  ?>" name="<?php echo $course->getYellowYardsTotal() . '_' . $course->hole_ID  ?>" value="<?php echo $course->getYellowYardsTotal(); ?>"><?php echo $course->getYellowYardsTotal(); ?></td>
                    <td class="red"><input type="hidden" maxlength="4" style="width: 60px;" id="<?php echo $course->getRedYardsTotal() . '_' . $course->hole_ID  ?>" name="<?php echo $course->getRedYardsTotal() . '_' . $course->hole_ID  ?>" value="<?php echo $course->getRedYardsTotal(); ?>"><?php echo $course->getRedYardsTotal(); ?></td>
                    <td class="blue"><input type="hidden" maxlength="4" style="width: 60px;" id="<?php echo $course->getBlueYardsTotal() . '_' . $course->hole_ID  ?>" name="<?php echo $course->getBlueYardsTotal() . '_' . $course->hole_ID  ?>" value="<?php echo $course->getBlueYardsTotal(); ?>"><?php echo $course->getBlueYardsTotal(); ?></td>


                </tr>

                <tr>
                    <th class="white">Course Rating</th>
                    <th class="yellow">Slope Rating</th>
                    <th class="red">Course Rating</th>
                    <th class="blue">Slope Rating</th>

                </tr>
                <tr>
                    <td class="white"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $course->getCrWhite() . '_' . $course->hole_ID  ?>" name="<?php echo $course->getCrWhite() . '_' . $course->hole_ID  ?>" value="<?php echo $course->getCrWhite(); ?>"><?php echo $course->getCrWhite(); ?></td>
                    <td class="yellow"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $course->getSrWhite() . '_' . $course->hole_ID  ?>" name="<?php echo $course->getSrWhite() . '_' . $course->hole_ID  ?>" value="<?php echo $course->getSrWhite(); ?>"><?php echo $course->getSrWhite(); ?></td>
                    <td class="red"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $course->getCrRed() . '_' . $course->hole_ID  ?>" name="<?php echo $course->getCrRed() . '_' . $course->hole_ID  ?>" value="<?php echo $course->getCrRed(); ?>"><?php echo $course->getCrRed(); ?></td>
                    <td class="blue"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $course->getSrRed() . '_' . $course->hole_ID  ?>" name="<?php echo $course->getSrRed() . '_' . $course->hole_ID  ?>" value="<?php echo $course->getSrRed(); ?>"><?php echo $course->getSrRed(); ?></td>

                </tr>


            </table>
            <?php







            ?>
            <table>
                <tr>
                    <th colspan="10"><?php echo $course->getName();  ?> Scorecard</th>
                <tr>
                <tr>
                    <th class=""></th>
                    <th class="name">Name</th>
                    <th class="white">Yds</th>
                    <th class="yellow">yds</th>
                    <th class="">Par</th>
                    <th class="">SI</th>
                    <th class="red">yds</th>
                    <th class="blue">yds</th>
                    <th class="">Par</th>
                    <th class="">SI</th>
                </tr>

                <?php
                $i = 0;
                $holes = $course->getHoles();
                $this->pretty_print($course);
                foreach ($holes as $holeName => $holeDetails) {
                    echo "Hole {$holeDetails['number']}: par {$holeDetails['white_par']}, yardage {$holeDetails['red_yards']}\n </br>
                Pro Tip: {$holeDetails['pro_tip']} <br /> Key is {$holeName} <br/>";



                    ////////////// Beginning of old for loop; for ($i=0; $i < count($course->holes) ; $i++) {}


                ?>

                    <tr>
                        <td><?php echo $holeDetails['number']; ?></td>

                        <td><input maxlength="20" style="width: 200px;" id="<?php echo $holeDetails['name'] . '_' . $holeDetails['hole_ID']  ?>" name="<?php echo $holeDetails['red_par_total'] . '_' . $holeDetails['hole_ID']  ?>" value="<?php echo $holeDetails['name']; ?>"></td>

                        <td class="white"><input maxlength="3" style="width: 40px;" id="<?php echo $holeDetails['white_yards'] . '_' . $holeDetails['hole_ID']  ?>" name="<?php echo $holeDetails['red_par_total'] . '_' . $holeDetails['hole_ID']  ?>" value="<?php echo $holeDetails['white_yards']; ?>"></td>

                        <td class="yellow"><input maxlength="3" style="width: 40px;" id="<?php echo $holeDetails['yellow_yards'] . '_' . $course->hole_ID  ?>" name="<?php echo $holeDetails['yellow_yards'] . '_' . $holeDetails['hole_ID']  ?>" value="<?php echo $holeDetails['yellow_yards']; ?>"></td>

                        <td class=""><input maxlength="3" style="width: 40px;" id="<?php echo $holeDetails['yellow_par'] . '_' . $holeDetails['hole_ID']  ?>" name="<?php echo $holeDetails['yellow_par'] . '_' . $holeDetails['hole_ID']  ?>" value="<?php echo $holeDetails['yellow_par']; ?>"></td>

                        <td><input maxlength="3" style="width: 40px;" id="<?php echo $holeDetails['si_white'] . '_' . $holeDetails['hole_ID']  ?>" name="<?php echo $holeDetails['si_white'] . '_' . $holeDetails['hole_ID']  ?>" value="<?php echo $holeDetails['si_white']; ?>"></td>

                        <td class="red"><input maxlength="3" style="width: 40px;" id="<?php echo $holeDetails['red_yards'] . '_' . $holeDetails['hole_ID']  ?>" name="<?php echo $holeDetails['red_yards'] . '_' . $holeDetails['hole_ID']  ?>" value="<?php echo $holeDetails['red_yards']; ?>"></td>

                        <td class="blue"><input maxlength="3" style="width: 40px;" id="<?php echo $holeDetails['blue_yards'] . '_' . $holeDetails['hole_ID']  ?>" name="<?php echo $holeDetails['blue_yards'] . '_' . $holeDetails['hole_ID']  ?>" value="<?php echo $holeDetails['blue_yards']; ?>"></td>

                        <td><input maxlength="3" style="width: 40px;" id="<?php echo $holeDetails['red_par'] . '_' . $holeDetails['hole_ID']  ?>" name="<?php echo $holeDetails['red_par'] . '_' . $holeDetails['hole_ID']  ?>" value="<?php echo $holeDetails['red_par']; ?>"></td>

                        <td><input maxlength="3" style="width: 40px;" id="<?php echo $holeDetails['si_red'] . '_' . $holeDetails['hole_ID']  ?>" name="<?php echo $holeDetails['si_red'] . '_' . $holeDetails['hole_ID'] ?>" value="<?php echo $holeDetails['si_red']; ?>"></td>
                    </tr>

                    <?php
                    $wy_total += $holeDetails['white_yards'];
                    $yy_total += $holeDetails['yellow_yards'];
                    $ry_total += $holeDetails['red_yards'];
                    $by_total += $holeDetails['blue_yards'];

                    if ($i == 8) {
                    ?>
                        <tr>
                            <td>Front</td>
                            <td></td>
                            <td class="white"><?php echo $wy_total; ?></td>
                            <td class="yellow"><?php echo $yy_total; ?></td>
                            <td></td>
                            <td></td>
                            <td class="red"><?php echo $ry_total; ?></td>
                            <td class="blue"><?php echo $by_total; ?></td>
                            <td></td>
                            <td></td>
                        </tr>

                    <?php
                        $wy_total = 0;
                        $yy_total = 0;
                        $ry_total = 0;
                        $by_total = 0;
                    }

                    // Check for end of back nine and generate back nine totals row
                    if ($i == 17) {
                        $wy_total += $course->holes[$i + 1]->white_yards;
                        $yy_total += $course->holes[$i + 1]->yellow_yards;
                        $ry_total += $course->holes[$i + 1]->red_yards;
                        $by_total += $course->holes[$i + 1]->blue_yards;

                    ?>
                        <tr>
                            <td>Back</td>
                            <td></td>
                            <td class="white"><?php echo $wy_total; ?></td>
                            <td class="yellow"><?php echo $yy_total; ?></td>
                            <td></td>
                            <td></td>
                            <td class="red"><?php echo $ry_total; ?></td>
                            <td class="blue"><?php echo $by_total; ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                    }
                    $i++;
                    ?>

                <?php } //////////////// End of for loop ////////////////////////////////////
                ?>



                <!-- Output Totals row after all holes for the current course have been processed -->

                <tr>
                    <td>Totals</td>
                    <td></td>
                    <td class="white"><?php echo $course->white_yards_total; ?></td>
                    <td class="yellow"><?php echo $course->yellow_yards_total; ?></td>
                    <td></td>
                    <td></td>
                    <td class="red"><?php echo $course->red_yards_total; ?></td>
                    <td class="blue"><?php echo $course->blue_yards_total; ?></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

<?php

        }
    }

    public function showClub()
    {
        return "
        <div id='saved-club'>
            <h3>{$this->getClubName()}</h3>
            <div>About Club: {$this->getAboutClub()}</div>
            <div>Address: {$this->getAddress1()}</div>
            <div>Address: {$this->getAddress2()}</div>
            <div>Town/City: {$this->getTownCity()}</div>
            <div>Postcode: {$this->getPostcode()}</div>
            <div>County: {$this->getCounty()}</div>
            <div>Country: {$this->getCountry()}</div>
            <div>GPS: {$this->getGps()}</div>
            <div>Telephone: {$this->getPhone()}</div>
            <div>Email: {$this->getEmail()}</div>
            <div>Facebook: {$this->getFacebook()}</div>
            <div>Twitter: {$this->getTwitter()}</div>
            <div><button id='edit-new-club'>Edit</button></div>
        </div>
        ";
    }

    public function pretty_print($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
    /////////////// Getters and Setters //////////////////////////////

    public function getErrorMessage()
    {
        return $this->error_message;
    }

    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
    }

    public function getMembers()
    {
        return $this->members;
    }

    public function setGolfClub($members)
    {
        $this->members = $members;
    }

    public function getClubID()
    {
        return $this->club_ID;
    }

    public function setClubID($club_ID)
    {
        $this->club_ID = $club_ID;
    }

    public function getCreatedBy()
    {
        return $this->created_by;
    }

    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
    }

    public function getClubCourses()
    {
        return $this->club_courses;
    }

    public function setClubCourses($club_courses)
    {
        $this->club_courses = $club_courses;
    }

    public function getClubName()
    {
        return $this->club_name;
    }

    public function setClubName($club_name)
    {
        $this->club_name = $club_name;
    }

    public function getDateCreated()
    {
        return $this->date_created;
    }

    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    public function getAboutClub()
    {
        return $this->about_club;
    }

    public function setAboutClub($about_club)
    {
        $this->about_club = $about_club;
    }

    public function getAddress1()
    {
        return $this->address_1;
    }

    public function setAddress1($address_1)
    {
        $this->address_1 = $address_1;
    }

    public function getAddress2()
    {
        return $this->address_2;
    }

    public function setAddress2($address_2)
    {
        $this->address_2 = $address_2;
    }

    public function getTownCity()
    {
        return $this->town_city;
    }

    public function setTownCity($town_city)
    {
        $this->town_city = $town_city;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    public function getCounty()
    {
        return $this->county;
    }

    public function setCounty($county)
    {
        $this->county = $county;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getGps()
    {
        return $this->gps;
    }

    public function setGps($gps)
    {
        $this->gps = $gps;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSocial()
    {
        return $this->social;
    }

    public function setSocial($social)
    {
        $this->social = $social;
    }

    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    public function getFacebook()
    {
        return $this->facebook;
    }

    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    public function getTwitter()
    {
        return $this->twitter;
    }

    public function setPostID($postID)
    {
        $this->post_ID = $postID;
    }

    public function getPostID()
    {
        return $this->post_ID;
    }
    /////////////// End of Getters and Setters /////////////////////////////








}
