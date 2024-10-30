<?php

require_once( PWG_PLUGIN_DIR . '/classes/holes.php' );

class golfCourse
{
    private $holes;
    private $course_ID;
    private $created_by;
    private $club_ID;
    private $name;
    private $club_name;
    private $course_overview;

    private $blue_yards_total;
    private $red_yards_total;
    private $yellow_yards_total;
    private $white_yards_total;

    private $blue_par_total;
    private $red_par_total;
    private $yellow_par_total;
    private $white_par_total;

    private $cr_blue;
    private $sr_blue;
    private $cr_red;
    private $sr_red;
    private $cr_yellow;
    private $sr_yellow;
    private $cr_white;
    private $sr_white;
    
    private $completed;


    // constructor

    public function __construct($course)
    {
        if ( $course )
        {
            $this->populate_class( $course );
            //print_r('<strong>' . $course_ID . '</strong>');
        }
    }

    public function show_course_scorecard()
    { 
            

               
                $holes = new Holes($this->getCourseId());
                

                
            ?>
                
                <table id="course_details">
                    <tr>
                        <th colspan="10"><?php echo $this->getClubName();  ?> Details</th>
                    </tr>
                    <tr>
                        <th>Par</th>
                        <td class="white"><?php echo $this->getWhiteParTotal(); ?></td>
                        <td class="yellow"><?php echo $this->getYellowParTotal(); ?></td>
                        <td class="red"><?php echo $this->getRedParTotal(); ?></td>
                        <td class="blue"><?php echo $this->getBlueParTotal(); ?></td>
                    </tr>
                    <tr>
                        <th>Yards</th>
                        <td class="white"><?php echo $this->getWhiteYardsTotal(); ?></td>
                        <td class="yellow"><?php echo $this->getYellowYardsTotal(); ?></td>
                        <td class="red"><?php echo $this->getRedYardsTotal(); ?></td>
                        <td class="blue"><?php echo $this->getBlueYardsTotal(); ?></td>
                    </tr>
                    <tr>
                        <th>CR</th>
                        <td class="white"><?php echo $this->getCrWhite(); ?></td>
                        <td class="yellow"><?php echo $this->getCrYellow(); ?></td>
                        <td class="red"><?php echo $this->getCrRed(); ?></td>
                        <td class="blue"><?php echo $this->getCrBlue(); ?></td>
                    </tr>
                    <tr>
                        <th>SR</th>
                        <td class="white"><?php echo $this->getSrWhite(); ?></td>
                        <td class="yellow"><?php echo $this->getSrYellow(); ?></td>
                        <td class="red"><?php echo $this->getSrRed(); ?></td>
                        <td class="blue"><?php echo $this->getSrBlue(); ?></td>
                    </tr>
                </table>
                
                

            <?php
            $holes->build_table('front_nine');
            $holes->build_table('back_nine');

        
    }

    public static function show_new_golf_course()
    {
        //$course_ID = $this->getCourseId();
            //print_r( $this );
        $form = "
        <form action='" . esc_url( admin_url( "admin-post.php" ) ) . "' method='post'>" .
             wp_nonce_field( 'my_action','my-callback' ) . "
        
             <div><label for='course_ID'>Course ID</label>
             <input type='text' name='course_ID' id='course_ID' placeholder='Course ID' value=''>
             </div>
             <div>
             <label for='club_ID'>Club ID</label>
             <input type='text' name='club_ID' id='club_ID' placeholder='Club ID' value=''>
             </div>
             <div>
             <label for='name'>Course Name</label>
             <input type='text' name='name' id='name' placeholder='Name' value=''>
             </div>
             <div>
             <label for='course_overview'>Course Overview</label>
             <input type='text' name='course_overview' id='course_overview' placeholder='Course Overview' value=''>
             </div>
             <div>
             <label for='red_yards_total'>Red Yards Total</label>
             <input type='text' name='red_yards_total' id='red_yards_total' placeholder='Red Yards Total' value=''>
             </div>
             <div>
             <label for='yellow_yards_total'>Yellow Yards Total</label>
             <input type='text' name='yellow_yards_total' id='yellow_yards_total' placeholder='Yellow Yards Total' value=''>
             </div>
             <div>
             <label for='white_yards_total'>White Yards Total</label>
             <input type='text' name='white_yards_total' id='white_yards_total' placeholder='White Yards Total' value=''>
             </div>
             <div>
             <label for='blue_yards_total'>Blue Yards Total</label>
             <input type='text' name='blue_yards_total' id='blue_yards_total' placeholder='Blue Yards Total' value=''>
             </div>
             <div>
             <label for='red_par_total'>Red Par Total</label>
             <input type='text' name='red_par_total' id='red_par_total' placeholder='Red Par Total' value=''>
             </div>
             <div>
             <label for='yellow_par_total'>Yellow Par Total</label>
             <input type='text' name='yellow_par_total' id='yellow_par_total' placeholder='Yellow Par Total' value=''>
             </div>
             <div>
             <label for='white_par_total'>White Par Total</label>
             <input type='text' name='white_par_total' id='white_par_total' placeholder='White Par Total' value=''>
             </div>
             <div>
             <label for='blue_par_total'>Blue Par Total</label>
             <input type='text' name='blue_par_total' id='blue_par_total' placeholder='Blue Par Total' value=''>
             </div>
             <div>
             <label for='cr_blue'>CR Blue</label>
             <input type='text' name='cr_blue' id='cr_blue' placeholder='CR Blue' value=''>
             </div>
             <div>
             <label for='sr_blue'>SR Blue</label>
             <input type='text' name='sr_blue' id='sr_blue' placeholder='SR Blue' value=''>
             </div>
             <div>
             <label for='cr_white'>CR White</label>
             <input type='text' name='cr_white' id='cr_white' placeholder='CR White' value=''>
             </div>
             <div>
             <label for='sr_white'>SR White</label>
             <input type='text' name='sr_white' id='sr_white' placeholder='SR White' value=''>
             </div>
             <div>
             <label for='cr_yellow'>CR Yellow</label>
             <input type='text' name='cr_yellow' id='cr_yellow' placeholder='CR Yellow' value=''>
             </div>
             <div>
             <label for='sr_yellow'>SR Yellow</label>
             <input type='text' name='sr_yellow' id='sr_yellow' placeholder='SR Yellow' value=''>
             </div>
             <div>
             <label for='cr_red'>CR Red</label>
             <input type='text' name='cr_red' id='cr_red' placeholder='CR Red' value=''>
             </div>
             <div>
             <label for='sr_red'>SR Red</label>
             <input type='text' name='sr_red' id='sr_red' placeholder='SR Red' value=''>
             </div>
             <div>
             <input type='submit' value='Submit'>
             </div>
         </form>'";

        echo ($form);
    }

    public function show_golf_course()
    {
        //$course_ID = $this->getCourseId();
            //print_r( $this );
        $form = "
        <form action='" . esc_url( admin_url( "admin-post.php" ) ) . "' method='post'>" .
             wp_nonce_field( 'my_action','my-callback' ) . "
        
             <div><label for='course_ID'>Course ID</label>
             <input type='text' name='course_ID' id='course_ID' placeholder='Course ID' value='"  . $this->getCourseId() .  "'>
             </div>
             <div>
             <label for='club_ID'>Club ID</label>
             <input type='text' name='club_ID' id='club_ID' placeholder='Club ID' value='" . $this->getClubId() .  "'>
             </div>
             <div>
             <label for='name'>Course Name</label>
             <input type='text' name='name' id='name' placeholder='Name' value='" . $this->getClubName() .  "'>
             </div>
             <div>
             <label for='course_overview'>Course Overview</label>
             <input type='text' name='course_overview' id='course_overview' placeholder='Course Overview' value='" . $this->getCourseOverview() .  "'>
             </div>
             <div>
             <label for='red_yards_total'>Red Yards Total</label>
             <input type='text' name='red_yards_total' id='red_yards_total' placeholder='Red Yards Total' value='" . $this->getRedYardsTotal() .  "'>
             </div>
             <div>
             <label for='yellow_yards_total'>Yellow Yards Total</label>
             <input type='text' name='yellow_yards_total' id='yellow_yards_total' placeholder='Yellow Yards Total' value='" . $this->getYellowParTotal() .  "'>
             </div>
             <div>
             <label for='white_yards_total'>White Yards Total</label>
             <input type='text' name='white_yards_total' id='white_yards_total' placeholder='White Yards Total' value='" . $this->getWhiteYardsTotal() .  "'>
             </div>
             <div>
             <label for='blue_yards_total'>Blue Yards Total</label>
             <input type='text' name='blue_yards_total' id='blue_yards_total' placeholder='Blue Yards Total' value='" . $this->getBlueYardsTotal() .  "'>
             </div>
             <div>
             <label for='red_par_total'>Red Par Total</label>
             <input type='text' name='red_par_total' id='red_par_total' placeholder='Red Par Total' value='" . $this->getRedParTotal() .  "'>
             </div>
             <div>
             <label for='yellow_par_total'>Yellow Par Total</label>
             <input type='text' name='yellow_par_total' id='yellow_par_total' placeholder='Yellow Par Total' value='" . $this->getYellowParTotal() .  "'>
             </div>
             <div>
             <label for='white_par_total'>White Par Total</label>
             <input type='text' name='white_par_total' id='white_par_total' placeholder='White Par Total' value='" . $this->getWhiteParTotal() .  "'>
             </div>
             <div>
             <label for='blue_par_total'>Blue Par Total</label>
             <input type='text' name='blue_par_total' id='blue_par_total' placeholder='Blue Par Total' value='" . $this->getBlueParTotal() .  "'>
             </div>
             <div>
             <label for='cr_blue'>CR Blue</label>
             <input type='text' name='cr_blue' id='cr_blue' placeholder='CR Blue' value='" . $this->getCrBlue() .  "'>
             </div>
             <div>
             <label for='sr_blue'>SR Blue</label>
             <input type='text' name='sr_blue' id='sr_blue' placeholder='SR Blue' value='" . $this->getSrBlue() .  "'>
             </div>
             <div>
             <label for='cr_white'>CR White</label>
             <input type='text' name='cr_white' id='cr_white' placeholder='CR White' value='" . $this->getCrWhite() .  "'>
             </div>
             <div>
             <label for='sr_white'>SR White</label>
             <input type='text' name='sr_white' id='sr_white' placeholder='SR White' value='" . $this->getSrWhite() .  "'>
             </div>
             <div>
             <label for='cr_yellow'>CR Yellow</label>
             <input type='text' name='cr_yellow' id='cr_yellow' placeholder='CR Yellow' value='" . $this->getCrYellow() .  "'>
             </div>
             <div>
             <label for='sr_yellow'>SR Yellow</label>
             <input type='text' name='sr_yellow' id='sr_yellow' placeholder='SR Yellow' value='" . $this->getSrYellow() .  "'>
             </div>
             <div>
             <label for='cr_red'>CR Red</label>
             <input type='text' name='cr_red' id='cr_red' placeholder='CR Red' value='" . $this->getCrRed() .  "'>
             </div>
             <div>
             <label for='sr_red'>SR Red</label>
             <input type='text' name='sr_red' id='sr_red' placeholder='SR Red' value='" . $this->getSrRed() .  "'>
             </div>
             <div>
             <input type='submit' value='Submit'>
             </div>
         </form>'";

        echo ($form);
    }

    function populate_class($course)
    {
        global $wpdb;
        if ( is_object( $course ))
        {
                $this->setCourseId($course->course_ID) ;
                $this->setClubId($course->club_ID);
                $this->setCourseName($course->name);
                $this->setClubName($course->club_name);
                $this->setCourseOverview( $course->course_overview ) ;

                $this->setBlueYardsTotal( $course->blue_yards_total ) ;
                $this->setRedYardsTotal( $course->red_yards_total ) ;
                $this->setYellowYardsTotal( $course->yellow_yards_total ) ;
                $this->setWhiteYardsTotal( $course->white_yards_total ) ;

                $this->setBlueParTotal( $course->blue_par_total ) ;
                $this->setRedParTotal( $course->red_par_total ) ;
                $this->setYellowParTotal( $course->yellow_par_total ) ;
                $this->setWhiteParTotal( $course->white_par_total ) ;

                $this->setCrBlue( $course->cr_blue ) ;
                $this->setSrBlue( $course->sr_blue ) ;

                $this->setCrRed( $course->cr_red ) ;
                $this->setSrRed( $course->sr_red ) ;
                
                $this->setCrYellow( $course->cr_yellow ) ;
                $this->setSrYellow( $course->sr_yellow ) ;

                $this->setCrWhite( $course->cr_white ) ;
                $this->setSrWhite( $course->sr_white ) ;


        } else {

        
            

            $course_sql = "SELECT *
            FROM `wp_golf_courses` 
            WHERE `course_ID` = %d ";

            $golfcourse = $wpdb->get_row($wpdb->prepare($course_sql, $course));
            // print_r($golfcourse);
            if ($golfcourse)
            {
                $this->setCourseId($golfcourse->course_ID) ;
                $this->setClubId($golfcourse->club_ID);
                $this->setCourseName($golfcourse->name);
                $this->setClubName($golfcourse->name);
                $this->setCourseOverview( $golfcourse->course_overview ) ;

                $this->setBlueYardsTotal( $golfcourse->blue_yards_total ) ;
                $this->setRedYardsTotal( $golfcourse->red_yards_total ) ;
                $this->setYellowYardsTotal( $golfcourse->yellow_yards_total ) ;
                $this->setWhiteYardsTotal( $golfcourse->white_yards_total ) ;

                $this->setBlueParTotal( $golfcourse->blue_par_total ) ;
                $this->setRedParTotal( $golfcourse->red_par_total ) ;
                $this->setYellowParTotal( $golfcourse->yellow_par_total ) ;
                $this->setWhiteParTotal( $golfcourse->white_par_total ) ;

                $this->setCrBlue( $golfcourse->cr_blue ) ;
                $this->setSrBlue( $golfcourse->sr_blue ) ;

                $this->setCrRed( $golfcourse->cr_red ) ;
                $this->setSrRed( $golfcourse->sr_red ) ;
                
                $this->setCrYellow( $golfcourse->cr_yellow ) ;
                $this->setSrYellow( $golfcourse->sr_yellow ) ;

                $this->setCrWhite( $golfcourse->cr_white ) ;
                $this->setSrWhite( $golfcourse->sr_white ) ;

                //return $golfcourse;
                

            }
        }

        $holes = new Holes($this->course_ID);
        $this->setHoles($holes);



        // $course_ID = $this->course_ID;
        // $holeSQL = "SELECT * 
        // FROM `wp_holes`
        // WHERE `course_ID` = %d";
        // $holes = $wpdb->get_results($wpdb->prepare($holeSQL, $course_ID));
        // if ($holes){
        //     $this->setHoles($holes);
        // }
    }

    public function insertCourse()

    {
        global $wpdb;
        $new_club_sql = "INSERT INTO `wp_golf_courses` ('course_ID','club_ID','created_by','name','course_overview','red_yards_total','yellow_yards_total','white_yards_total','blue_yards_total','red_par_total','yellow_par_total','white_par_total','blue_par_total','cr_blue','sr_blue','cr_white','sr_white','cr_yellow','sr_yellow','cr_red','sr_red','completed') 
        VALUES (%d, %d, %d, %s, %s, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d )";
        $new_course_sql = "INSERT INTO `wp_golf_courses` ";
        $data = [
            'course_ID' => sanitize_text_field($this->course_ID),
            'club_ID' =>  sanitize_text_field($this->club_ID),
            'created_by' => sanitize_text_field($this->created_by),
            'name' => sanitize_text_field($this->name),
            'course_overview' => sanitize_text_field($this->course_overview),
            'red_yards_total' =>  sanitize_text_field($this->red_yards_total),
            'yellow_yards_total' => sanitize_text_field($this->yellow_yards_total),
            'white_yards_total' => sanitize_text_field($this->white_yards_total),
            'blue_yards_total' => sanitize_text_field($this->blue_yards_total), 
            'red_par_total' => sanitize_text_field($this->red_par_total), 
            'yellow_par_total' => sanitize_text_field($this->yellow_par_total), 
            'white_par_total' => sanitize_text_field($this->white_par_total), 
            'blue_par_total' => sanitize_text_field($this->blue_par_total), 
            'cr_blue' => sanitize_text_field($this->cr_blue), 
            'sr_blue' => sanitize_text_field($this->sr_blue),
            'cr_white' => sanitize_text_field($this->cr_white), 
            'sr_white' => sanitize_text_field($this->sr_white), 
            'cr_yellow' => sanitize_text_field($this->cr_yellow), 
            'sr_yellow' => sanitize_text_field($this->sr_yellow), 
            'cr_red' => sanitize_text_field($this->cr_red), 
            'sr_red' => sanitize_text_field($this->sr_red), 
            'completed' => sanitize_text_field($this->completed)
            ];

            $results = $wpdb->query($wpdb->prepare($new_club_sql, $data));

            if ($results) {
                return $wpdb->insert_id;
            } else {
                return false;
            }
    }

    public function updateCourse($course_ID) 

    {
        global $wpdb;
        $sql = "UPDATE `wp_golf_course` SET `club_ID` = %s, `created_by` = %d, `name` = %s, `course_overview` = %s,
         `red_yards_total` = %d, `yellow_yards_total` = %d, `white_yards_total` = %d, `blue_yards_total` = %d,
          `red_par_total` = %d, `yellow_par_total` = %d , `white_par_total` = %d, `blue_par_total` = %d, 
          `cr_blue` = %d, `sr_blue` = %d, `cr_white` = %d, `sr_white` = %d, `cr_yellow` = %d, `sr_yellow` = %d, `cr_red` = %d, `sr_red` = %d, `completed` WHERE `course_ID` = %d";
        $results = $wpdb->query(
            $wpdb->prepare(
                $sql, 
                $this->club_ID, 
                $this->created_by, 
                $this->name, 
                $this->course_overview, 
                $this->red_yards_total, 
                $this->yellow_yards_total, 
                $this->white_yards_total, 
                $this->blue_yards_total, 
                $this->red_par_total, 
                $this->yellow_par_total, 
                $this->white_par_total,
                $this->blue_par_total,
                $this->yellow_par_total,
                $this->cr_blue,
                $this->sr_white,
                $this->sr_white,
                $this->cr_yellow,
                $this->sr_yellow,
                $this->cr_red,
                $this->sr_red,
                $this->completed,
                $course_ID
            )
        );
        if ($results) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCourse($course_ID)
    {
        global $wpdb;
        
        $delete_holes_sql="DELETE FROM `wp_holes` WHERE `course_ID` = %d";

        $delete_courses_sql ="DELETE FROM `wp_golf_courses` WHERE `course_ID` = %d";

        $results = [];
        $results[] = $wpdb->query($wpdb->prepare($delete_holes_sql, $course_ID));
        $results[] = $wpdb->query($wpdb->prepare($delete_courses_sql, $course_ID));
        return $results;




    }


    //////////////// Getters and Setters ///////////////////////////

    public function getHoles()
    {
        return $this->holes;
    }

    public function setHoles($holes)
    {
        $this->holes = $holes;
    }
    
    public function getCourseId()
    {
        return $this->course_ID;
    }

    public function setCourseId($course_ID)
    {
        $this->course_ID = $course_ID;
    }

    public function getClubId()
    {
        return $this->club_ID;
    }

    public function setClubId($club_ID)
    {
        $this->club_ID = $club_ID;
    }

    public function getCourseName()
    {
        return $this->name;
    }

    public function setCourseName($name)
    {
        $this->name = $name;
    }

    public function getClubName()
    {
        return $this->club_name;
    }

    public function setClubName($club_name)
    {
        $this->club_name = $club_name;
    }

    public function getCourseOverview()
    {
        return $this->course_overview;
    }

    public function setCourseOverview($course_overview)
    {
        $this->course_overview = $course_overview;
    }

    public function getRedYardsTotal()
    {
        return $this->red_yards_total;
    }

    public function setRedYardsTotal($red_yards_total)
    {
        $this->red_yards_total = $red_yards_total;
    }

    public function getYellowYardsTotal()
    {
        return $this->yellow_yards_total;
    }

    public function setYellowYardsTotal($yellow_yards_total)
    {
        $this->yellow_yards_total = $yellow_yards_total;
    }

    public function getWhiteYardsTotal()
    {
        return $this->white_yards_total;
    }

    public function setWhiteYardsTotal($white_yards_total)
    {
        $this->white_yards_total = $white_yards_total;
    }

    public function getBlueYardsTotal()
    {
        return $this->blue_yards_total;
    }

    public function setBlueYardsTotal($blue_yards_total)
    {
        $this->blue_yards_total = $blue_yards_total;
    }

    public function getRedParTotal()
    {
        return $this->red_par_total;
    }

    public function setRedParTotal($red_par_total)
    {
        $this->red_par_total = $red_par_total;
    }

    public function getYellowParTotal()
    {
        return $this->yellow_par_total;
    }

    public function setYellowParTotal($yellow_par_total)
    {
        $this->yellow_par_total = $yellow_par_total;
    }

    public function getWhiteParTotal()
    {
        return $this->white_par_total;
    }

    public function setWhiteParTotal($white_par_total)
    {
        $this->white_par_total = $white_par_total;
    }

    public function getBlueParTotal()
    {
        return $this->blue_par_total;
    }

    public function setBlueParTotal($blue_par_total)
    {
        $this->blue_par_total = $blue_par_total;
    }

    public function getCrBlue()
    {
        return $this->cr_blue;
    }

    public function setCrBlue($cr_blue)
    {
        $this->cr_blue = $cr_blue;
    }

    public function getSrBlue()
    {
        return $this->sr_blue;
    }

    public function setSrBlue($sr_blue)
    {
        $this->sr_blue = $sr_blue;
    }

    public function getCrWhite()
    {
        return $this->cr_white;
    }

    public function setCrWhite($cr_white)
    {
        $this->cr_white = $cr_white;
    }

    public function getSrWhite()
    {
        return $this->sr_white;
    }

    public function setSrWhite($sr_white)
    {
        $this->sr_white = $sr_white;
    }

    public function getCrYellow()
    {
        return $this->cr_yellow;
    }

    public function setCrYellow($cr_yellow)
    {
        $this->cr_yellow = $cr_yellow;
    }

    public function getSrYellow()
    {
        return $this->sr_yellow;
    }

    public function setSrYellow($sr_yellow)
    {
        $this->sr_yellow = $sr_yellow;
    }

    public function getCrRed()
    {
        return $this->cr_red;
    }

    public function setCrRed($cr_red)
    {
        $this->cr_red = $cr_red;
    }

    public function getSrRed()
    {
        return $this->sr_red;
    }

    public function setSrRed($sr_red)
    {
        $this->sr_red = $sr_red;
    }

    //////////////// End Of Getters and Setters ///////////////////////////

    

    




}

