<?php


class pwgGolfCourse
{
    private $course_ID;
    private $club_ID;
    private $course_name;
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
    


    // constructor

    public function __construct($course_ID)
    {
        if ( $course_ID >= 1 )
        {
            $this->populate_class( $course_ID );
            //print_r('<strong>' . $course_ID . '</strong>');
        }
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

    function populate_class($course_ID)
    {
        global $wpdb;

        $course_sql = "SELECT wp_golf_courses.*, wp_golf_clubs.club_ID, wp_golf_clubs.club_name 
        FROM wp_golf_courses 
        INNER JOIN wp_golf_clubs 
        ON wp_golf_courses.club_ID = wp_golf_clubs.club_ID 
        WHERE wp_golf_courses.course_ID = %d 
        AND wp_golf_clubs.club_ID IS NOT NULL";

        $golfcourse = $wpdb->get_row($wpdb->prepare($course_sql, $course_ID));
            //print_r($golfcourse);
        if (is_object($golfcourse))
        {
            $this->setCourseId($golfcourse->course_ID) ;
            $this->setClubId($golfcourse->club_ID);
            $this->setCourseName($golfcourse->name);
            $this->setClubName($golfcourse->club_name);
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




    //////////////// Getters and Setters ///////////////////////////
    
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
        return $this->course_name;
    }

    public function setCourseName($course_name)
    {
        $this->course_name = $course_name;
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

    

    public function create_golf_course
    (
        $course_ID,
        $club_ID,
        $course_name,
        $club_name,
        $course_overview,

        $blue_yards_total,
        $red_yards_total,
        $yellow_yards_total,
        $white_yards_total,
        
        $blue_par_total,
        $red_par_total,
        $yellow_par_total,
        $white_par_total,
        
        $cr_blue,
        $sr_blue,
        $cr_red,
        $sr_red,
        $cr_yellow,
        $sr_yellow,
        $cr_white,
        $sr_white,


    ) {
        $this->course_ID = $course_ID;
        $this->club_ID = $club_ID;
        $this->course_name = $course_name;
        $this->course_name = $club_name;
        $this->course_overview = $course_overview;
        $this->red_yards_total = $red_yards_total;
        $this->yellow_yards_total = $yellow_yards_total;
        $this->white_yards_total = $white_yards_total;
        $this->blue_yards_total = $blue_yards_total;
        $this->red_par_total = $red_par_total;
        $this->yellow_par_total = $yellow_par_total;
        $this->white_par_total = $white_par_total;
        $this->blue_par_total = $blue_par_total;
        $this->cr_blue = $cr_blue;
        $this->sr_blue = $sr_blue;
        $this->cr_white = $cr_white;
        $this->sr_white = $sr_white;
        $this->cr_yellow = $cr_yellow;
        $this->sr_yellow = $sr_yellow;
        $this->cr_red = $cr_red;
        $this->sr_red = $sr_red;
    }




}

