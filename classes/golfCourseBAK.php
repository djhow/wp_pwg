<?php

require_once( PWG_PLUGIN_DIR . '/classes/holes.php' );

class PWG_GolfCourse
{
    private $holes;
    private $course_ID;
    private $post_ID;
    private $created_by;
    private $club_ID;
    private $name;
    private $club_name;
    private $course_overview;
    private $number_holes;
    private $white_tees;
    private $yellow_tees;
    private $red_tees;
    private $blue_tees;

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

    public function __construct($course_ID = 1)
    {
        if ( $course_ID )
        {
            $this->populate_class( $course_ID );
            //$this->pretty_print( '<h1>Course_ID is ' . $course_ID . '</h1>');
        }
    }

    public function add_new_course(){


    }

    public function show_course_scorecard()
    { 

        //$this->pretty_print($this);
            

            
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
        $course_ID = $this->getCourseId();
        $holes = new Holes();
        $holes->populate_class_by_ID($course_ID);
        $holes->build_table();


    
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
                $this->setCourseId($course->course_ID);
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


        } else 
        {

            $course_sql = "SELECT *
            FROM `wp_golf_courses` 
            WHERE `course_ID` = %d";

            $golfcourse = $wpdb->get_row($wpdb->prepare($course_sql, $course));
            
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

        $holes = new Holes( );
        $holes->populate_class_by_ID( $this->getCourseId());
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
        $args = [
            'course_ID' => $this->getCourseId(),
            'club_ID' =>  $this->getClubId(),
            'name' => $this->getCourseName(),
            'course_overview' => $this->getCourseOverview(),
            'number_holes' => $this->getNumberHoles(),
            'white_tees' => $this->getWhiteTees(),
            'yellow_tees' => $this->getYellowTees(),
            'red_tees' => $this->getRedTees(),
            'blue_tees' => $this->getBlueTees(),
            'white_yards_total' => $this->getWhiteYardsTotal(),
            'yellow_yards_total' => $this->getYellowYardsTotal(),
            'red_yards_total' => $this->getRedYardsTotal(),
            'blue_yards_total' => $this->getBlueYardsTotal(), 
            'red_par_total' => $this->getRedParTotal(), 
            'yellow_par_total' => $this->getYellowParTotal(), 
            'white_par_total' => $this->getWhiteParTotal(), 
            'blue_par_total' => $this->getBlueParTotal(), 
            'cr_blue' => $this->getCrBlue(), 
            'sr_blue' => $this->getSrBlue(),
            'cr_white' => $this->getCrWhite(), 
            'sr_white' => $this->getSrWhite(), 
            'cr_yellow' => $this->getCrYellow(), 
            'sr_yellow' => $this->getSrYellow(), 
            'cr_red' => $this->getCrRed(), 
            'sr_red' => $this->getSrRed(), 
            ];

            $formats = [
                '%d','%d', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d'
            ];

            $results = $wpdb->insert( 'wp_golf_courses', $args, $formats );
            // if (WP_DEBUG_LOG) {
            //      error_log(print_r($wpdb, true));
            //     }
            if ($results) {
                return $wpdb->insert_id;
            } else {
                return false;
            }
    }

   
    public function updateCourse($course_ID){
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


    public function pretty_print($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
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

    public function getPostId()
    {
        return $this->post_ID;
    }

    public function setPostId($post_ID)
    {
        $this->post_ID = $post_ID;
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

    public function setNumberHoles($number_holes){
        $this->number_holes = $number_holes;
    }

    public function getNumberHoles(){
        return $this->number_holes;
    }

    public function setWhiteTees($white_tees){
        $this->white_tees = $white_tees;
    }

    public function getWhiteTees(){
        return $this->white_tees;
    }

    public function setYellowTees($yellow_tees){
        $this->yellow_tees = $yellow_tees;
    }

    public function getYellowTees(){
        return $this->yellow_tees;
    }

    public function setRedTees($red_tees){
        $this->red_tees = $red_tees;
    }

    public function getRedTees(){
        return $this->red_tees;
    }

    public function setBlueTees($blue_tees){
        $this->blue_tees = $blue_tees;
    }

    public function getblueTees(){
        return $this->blue_tees;
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

