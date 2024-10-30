<?php
//namespace pwgGolfClub;

/**
 */

class pwgGolfClub {

    private $club_ID;
    private $created_by;
    private $date_created;
    private $club_name;
    private $about_club;
    private $address_1;
    private $address_2;
    private $town_city;
    private $postcode;
    private $gps;
    private $phone;
    private $email;
    private $social;
    private $club_courses;

    private $error_message;

    private $members;

    public function __construct($club_ID) {

        if ($club_ID >= 1)
        {
             $this->populate_club($club_ID);
        }
    }

    public function save_scorecard()
    {

        /**
         *  get the golf club
         * 
         *  iterate through the golf courses
         * 
         * iterate through the holes and save
         * 
         * 
         */

    }
    
    public function show_scorcard( $course_ID = 0 )
    {
        
    $golfcourses = $this->getClubCourses();
        
        $holesnames = 0;
    
    
    
        $columns_count = 0;
        for ( $i = 0; $i < count($golfcourses); $i++ )
        {           
            if ( 1 > 0)
            {
                $golfcourses[$i]->coursename = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->white_yards_total > 0)
            {
                $golfcourses[$i]->white_yards = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->yellow_yards_total > 0)
            {
                $golfcourses[$i]->yellow_yards = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->red_yards_total > 0)
            {
                $golfcourses[$i]->red_yards = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->blue_yards_total > 0)
            {
                $golfcourses[$i]->blue_yards = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->white_par_total > 0)
            {
                $golfcourses[$i]->white_par = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->yellow_par_total > 0)
            {
                $golfcourses[$i]->yellow_par = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->red_par_total > 0)
            {
                $golfcourses[$i]->red_par = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->blue_par_total > 0)
            {
                $golfcourses[$i]->blue_par = $i;
                $columns_count++;
            }
    
        }
        echo $columns_count;
        $this->pretty_print($golfcourses);

foreach ($golfcourses as $course) {
    
  $wy_total = 0;
  $yy_total = 0;
  $ry_total = 0;
  $by_total = 0;
?>
<style>
.diagonal-cell {
  transform: skew(-45deg);
  background-color: #ddd;
  padding: 10px;
}

.yellow {
    background-color: lightyellow ;
}
.red {
    background-color: lightcoral;
}
.blue {
    background-color: lightblue;
    
}
.white {
    background-color: white;
}
#course_details{
    width: 400px;
}

table {
    margin:0;
    padding:0;
}
.red,.yellow,.white,.blue, td {
    min-width: 80px;
    text-align: center;
}
.name {
    min-width: 200px;
}
</style>
<table id="course_details">
    <tr>
        <th colspan="10"><?php echo $course->name;  ?> Details</th>
    </tr>
    <tr>
        <th class="white">Par</th>
        <th class="yellow">Par</th>
        <th class="red">Par</th>
        <th class="blue">Par</th>

    </tr>
    <tr>
        <td class="white"><?php echo $course->white_par_total;?></td>
        <td class="yellow"><?php echo $course->yellow_par_total;?></td>
        <td class="red"><?php echo $course->red_par_total;?></td>
        <td class="blue"><?php echo $course->blue_par_total;?></td>

    </tr>
    <tr>
        <th class="white">Yds</th>
        <th class="yellow">Yds</th>
        <th class="red">Yds</th>
        <th class="blue">Yds</th>

    </tr>
    <tr>
        <td class="white"><?php echo $course->white_yards_total;?></td>
        <td class="yellow"><?php echo $course->yellow_yards_total;?></td>
        <td class="red"><?php echo $course->red_yards_total;?></td>
        <td class="blue"><?php echo $course->blue_yards_total;?></td>


    </tr>
    
    <tr>
        <th class="white">Course Rating</th>
        <th class="yellow">Slope Rating</th>
        <th class="red">Course Rating</th>
        <th class="blue">Slope Rating</th>

    </tr>
    <tr>
        <td class="white"><?php echo $course->cr_white;?></td>
        <td class="yellow"><?php echo $course->sr_white;?></td>
        <td class="red"><?php echo $course->cr_red;?></td>
        <td class="blue"><?php echo $course->sr_red;?></td>

    </tr>
    
    
</table>
<?php







?>
<table>
    <tr>
        <th colspan="10"><?php echo $course->name;  ?> Scorecard</th>
    <tr>
  <tr>
    <th class=""></th>
    <th class="name">Name</th>
    <th class="white">WY</th>
    <th class="yellow">YY</th>
    <th class="">Par</th>
    <th class="">SI</th>
    <th class="red">RY</th>
    <th class="blue">BY</th>
    <th class="">Par</th>
    <th class="">SI</th>
  </tr>

  <?php
  for ($i=0; $i < count($course->holes) ; $i++) {
  ?>

  <tr>
    <td><?php echo $course->holes[$i]->number;?></td>
    <td><?php echo $course->holes[$i]->name; ?></td>
    <td class="white"><?php echo $course->holes[$i]->white_yards; ?></td>
    <td class="yellow"><?php echo $course->holes[$i]->yellow_yards; ?></td>
    <td class=""><?php echo $course->holes[$i]->yellow_par; ?></td>
    <td><?php echo $course->holes[$i]->si_white; ?></td>
    <td class="red"><?php echo $course->holes[$i]->red_yards; ?></td>
    <td class="blue"><?php echo $course->holes[$i]->blue_yards; ?></td>
    <td><?php echo $course->holes[$i]->red_par; ?></td>
    <td><?php echo $course->holes[$i]->si_red; ?></td>
  </tr>

  <?php
    $wy_total += $course->holes[$i]->white_yards;
    $yy_total += $course->holes[$i]->yellow_yards;
    $ry_total += $course->holes[$i]->red_yards;
    $by_total += $course->holes[$i]->blue_yards;

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
      $wy_total += $course->holes[$i+1]->white_yards;
      $yy_total += $course->holes[$i+1]->yellow_yards;
      $ry_total += $course->holes[$i+1]->red_yards;
      $by_total += $course->holes[$i+1]->blue_yards;
      
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
  ?>

  <?php } ?>



<!-- Output Totals row after all holes for the current course have been processed -->

  <tr>
    <td>Totals</td>
    <td></td>
    <td class="white"><?php echo $course->white_yards_total;?></td>
    <td class="yellow"><?php echo $course->yellow_yards_total;?></td>
    <td></td>
    <td></td>
    <td class="red"><?php echo $course->red_yards_total;?></td>
    <td class="blue"><?php echo $course->blue_yards_total;?></td>
    <td></td>
    <td></td>
  </tr>
</table>

<?php } 

        


    }


    public function show_edit_scorcard( $course_ID = 0 )
    {
        
    $golfcourses = $this->getClubCourses();
        
        $holesnames = 0;
    
    
    
        $columns_count = 0;
        for ( $i = 0; $i < count($golfcourses); $i++ )
        {           
            if ( 1 > 0)
            {
                $golfcourses[$i]->coursename = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->white_yards_total > 0)
            {
                $golfcourses[$i]->white_yards = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->yellow_yards_total > 0)
            {
                $golfcourses[$i]->yellow_yards = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->red_yards_total > 0)
            {
                $golfcourses[$i]->red_yards = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->blue_yards_total > 0)
            {
                $golfcourses[$i]->blue_yards = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->white_par_total > 0)
            {
                $golfcourses[$i]->white_par = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->yellow_par_total > 0)
            {
                $golfcourses[$i]->yellow_par = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->red_par_total > 0)
            {
                $golfcourses[$i]->red_par = $i;
                $columns_count++;
            }

            if ($golfcourses[$i]->blue_par_total > 0)
            {
                $golfcourses[$i]->blue_par = $i;
                $columns_count++;
            }
    
        }


foreach ($golfcourses as $course) {
    
  $wy_total = 0;
  $yy_total = 0;
  $ry_total = 0;
  $by_total = 0;
?>
<style>
.diagonal-cell {
  transform: skew(-45deg);
  background-color: #ddd;
  padding: 10px;
}

.yellow {
    background-color: lightyellow ;
}
.red {
    background-color: lightcoral;
}
.blue {
    background-color: lightblue;
    
}
.white {
    background-color: white;
}
#course_details{
    width: 400px;
}

table {
    margin:0;
    padding:0;
}
.red,.yellow,.white,.blue, td {
    min-width: 80px;
    text-align: center;
}
.name {
    min-width: 200px;
}
</style>
<table id="course_details">
    <tr>
        <th colspan="10"><?php echo $course->name;  ?> Details</th>
    </tr>
    <tr>
        <th class="white">Par</th>
        <th class="yellow">Par</th>
        <th class="red">Par</th>
        <th class="blue">Par</th>

    </tr>
    <tr>
        <td class="white"><input type="hidden" maxlength="2" style="width: 30px;" id="<?php echo $course->white_par_total . '_' . $course->hole_ID  ?>" name="<?php echo $course->white_par_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->white_par_total;?>"><?php echo $course->white_par_total;?></td>
        <td class="yellow"><input type="hidden" maxlength="2" style="width: 30px;" id="<?php echo $course->yellow_par_total . '_' . $course->hole_ID  ?>" name="<?php echo $course->yellow_par_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->yellow_par_total;?>"><?php echo $course->yellow_par_total;?></td>
        <td class="red"><input type="hidden" maxlength="2" style="width: 30px;" id="<?php echo $course->red_par_total . '_' . $course->hole_ID  ?>" name="<?php echo $course->red_par_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->red_par_total;?>"><?php echo $course->red_par_total;?></td>
        <td class="blue"><input type="hidden" maxlength="2" style="width: 30px;" id="<?php echo $course->red_par_total . '_' . $course->hole_ID  ?>" name="<?php echo $course->red_par_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->red_par_total;?>"><?php echo $course->blue_par_total;?></td>

    </tr>
    <tr>
        <th class="white">Yds</th>
        <th class="yellow">Yds</th>
        <th class="red">Yds</th>
        <th class="blue">Yds</th>

    </tr>
    <tr>
        <td class="white"><input type="hidden" maxlength="4" style="width: 60px;" id="<?php echo $course->white_yards_total . '_' . $course->hole_ID  ?>" name="<?php echo $course->white_yards_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->white_yards_total;?>"><?php echo $course->white_yards_total;?></td>
        <td class="yellow"><input type="hidden" maxlength="4" style="width: 60px;" id="<?php echo $course->yellow_yards_total . '_' . $course->hole_ID  ?>" name="<?php echo $course->yellow_yards_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->yellow_yards_total;?>"><?php echo $course->yellow_yards_total;?></td>
        <td class="red"><input type="hidden" maxlength="4" style="width: 60px;" id="<?php echo $course->red_yards_total . '_' . $course->hole_ID  ?>" name="<?php echo $course->red_yards_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->red_yards_total;?>"><?php echo $course->red_yards_total;?></td>
        <td class="blue"><input type="hidden" maxlength="4" style="width: 60px;" id="<?php echo $course->blue_yards_total . '_' . $course->hole_ID  ?>" name="<?php echo $course->blue_yards_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->blue_yards_total;?>"><?php echo $course->blue_yards_total;?></td>


    </tr>
    
    <tr>
        <th class="white">Course Rating</th>
        <th class="yellow">Slope Rating</th>
        <th class="red">Course Rating</th>
        <th class="blue">Slope Rating</th>

    </tr>
    <tr>
        <td class="white"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $course->cr_white . '_' . $course->hole_ID  ?>" name="<?php echo $course->cr_white . '_' . $course->hole_ID  ?>" value="<?php echo $course->cr_white;?>"><?php echo $course->cr_white;?></td>
        <td class="yellow"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $course->sr_white . '_' . $course->hole_ID  ?>" name="<?php echo $course->sr_white . '_' . $course->hole_ID  ?>" value="<?php echo $course->sr_white;?>"><?php echo $course->sr_white;?></td>
        <td class="red"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $course->cr_red . '_' . $course->hole_ID  ?>" name="<?php echo $course->cr_red . '_' . $course->hole_ID  ?>" value="<?php echo $course->cr_red;?>"><?php echo $course->cr_red;?></td>
        <td class="blue"><input type="hidden" maxlength="5" style="width: 50px;" id="<?php echo $course->sr_red . '_' . $course->hole_ID  ?>" name="<?php echo $course->sr_red . '_' . $course->hole_ID  ?>" value="<?php echo $course->sr_red;?>"><?php echo $course->sr_red;?></td>

    </tr>
    
    
</table>
<?php







?>
<table>
    <tr>
        <th colspan="10"><?php echo $course->name;  ?> Scorecard</th>
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
  for ($i=0; $i < count($course->holes) ; $i++) {
  ?>

  <tr>
    <td><?php echo $course->holes[$i]->number;?></td>
    <td><input maxlength="20" style="width: 200px;" id="<?php echo $course->holes[$i]->name . '_' . $course->hole_ID  ?>" name="<?php echo $course->red_par_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->holes[$i]->name;?>"></td>
    <td class="white"><input maxlength="3" style="width: 40px;" id="<?php echo $course->holes[$i]->white_yards . '_' . $course->hole_ID  ?>" name="<?php echo $course->red_par_total . '_' . $course->hole_ID  ?>" value="<?php echo $course->holes[$i]->white_yards;?>"></td>
    <td class="yellow"><input maxlength="3" style="width: 40px;" id="<?php echo $course->holes[$i]->yellow_yards . '_' . $course->hole_ID  ?>" name="<?php echo $course->yellow_yards . '_' . $course->hole_ID  ?>" value="<?php echo $course->holes[$i]->yellow_yards;?>"></td>
    <td class=""><input maxlength="3" style="width: 40px;" id="<?php echo $course->holes[$i]->yellow_par . '_' . $course->hole_ID  ?>" name="<?php echo $course->yellow_par . '_' . $course->hole_ID  ?>" value="<?php echo $course->holes[$i]->yellow_par;?>"></td>
    <td><input maxlength="3" style="width: 40px;" id="<?php echo $course->holes[$i]->si_white . '_' . $course->hole_ID  ?>" name="<?php echo $course->si_white . '_' . $course->hole_ID  ?>" value="<?php echo $course->holes[$i]->si_white;?>"></td>
    <td class="red"><input maxlength="3" style="width: 40px;" id="<?php echo $course->holes[$i]->red_yards . '_' . $course->hole_ID  ?>" name="<?php echo $course->red_yards . '_' . $course->hole_ID  ?>" value="<?php echo $course->holes[$i]->red_yards;?>"></td>
    <td class="blue"><input maxlength="3" style="width: 40px;" id="<?php echo $course->holes[$i]->blue_yards . '_' . $course->hole_ID  ?>" name="<?php echo $course->blue_yards . '_' . $course->hole_ID  ?>" value="<?php echo $course->holes[$i]->blue_yards;?>"></td>
    <td><input maxlength="3" style="width: 40px;" id="<?php echo $course->holes[$i]->red_par . '_' . $course->hole_ID  ?>" name="<?php echo $course->red_par . '_' . $course->hole_ID  ?>" value="<?php echo $course->holes[$i]->red_par;?>"></td>
    <td><input maxlength="3" style="width: 40px;" id="<?php echo $course->holes[$i]->si_red . '_' . $course->hole_ID  ?>" name="<?php echo $course->si_red . '_' . $course->hole_ID  ?>" value="<?php echo $course->holes[$i]->si_red;?>"></td>
  </tr>

  <?php
    $wy_total += $course->holes[$i]->white_yards;
    $yy_total += $course->holes[$i]->yellow_yards;
    $ry_total += $course->holes[$i]->red_yards;
    $by_total += $course->holes[$i]->blue_yards;

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
      $wy_total += $course->holes[$i+1]->white_yards;
      $yy_total += $course->holes[$i+1]->yellow_yards;
      $ry_total += $course->holes[$i+1]->red_yards;
      $by_total += $course->holes[$i+1]->blue_yards;
      
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
  ?>

  <?php } ?>



<!-- Output Totals row after all holes for the current course have been processed -->

  <tr>
    <td>Totals</td>
    <td></td>
    <td class="white"><?php echo $course->white_yards_total;?></td>
    <td class="yellow"><?php echo $course->yellow_yards_total;?></td>
    <td></td>
    <td></td>
    <td class="red"><?php echo $course->red_yards_total;?></td>
    <td class="blue"><?php echo $course->blue_yards_total;?></td>
    <td></td>
    <td></td>
  </tr>
</table>

<?php } 

        


    }

    public function populate_club( $clubID = 0)
    {
        global $wpdb;
        global $post;

        if ( $clubID > 0  )
        {   
            $club_ID = $clubID;
        } else {
            $club_ID = $post->ID;
        }

        
        $clubSQL = 'SELECT * FROM 
        `wp_golf_clubs` 
        WHERE `club_ID` = %d';

        $golfclub = $wpdb->get_row($wpdb->prepare($clubSQL, $club_ID));

        if ( is_object($golfclub) && $this->add_golf_club($golfclub) )
        {

            $coursesSQL = "SELECT * 
                           FROM `wp_golf_courses`
                           WHERE `club_ID` = %d";

            $golfcourses = $wpdb->get_results($wpdb->prepare($coursesSQL, $this->club_ID));
            $this->setClubCourses($golfcourses);
            $holesSQL = "SELECT * FROM `wp_holes` WHERE `course_ID` = %d";
            $id = 0;

            foreach ( $golfcourses as $course )
            { 
                $course_ID = $course->course_ID;

                $holes = $wpdb->get_results( $wpdb->prepare($holesSQL, $course_ID));

                if ( $holes[$id]->course_ID = $golfcourses[$id]->course_ID)
                {
                    $golfcourses[$id]->holes = $holes;
                }
                
                $id++;
            }
            $this->setClubCourses($golfcourses);  
        } else {
            $this->setErrorMessage('The Golf Club was not found.');
        }
    }

    public function show_holes($holes)
    {
        foreach($holes as $hole) {

            echo '<div>' . $hole->pro_tip . '</div>';
            echo "Hole ID: " . $hole->hole_ID;
            echo "Course ID: " . $hole->course_ID;
            echo "Number: " . $hole->number;
            echo "name: " . $hole->name;

            echo "Blue Yards: " . $hole->blue_yards;
            echo "Red Yards: " . $hole->red_yards;
            echo "Yellow Yards: " . $hole->yellow_yards;
            echo "White Yards: " . $hole->white_yards;

            echo "Blue Par: " . $hole->blue_par;
            echo "Red Par: " . $hole->red_par;
            echo "Yellow Par: " . $hole->yellow_par;
            echo "White Par: " . $hole->white_par;

            echo "Blue SI: " . $hole->blue_si;
            echo "Red SI: " . $hole->red_si;
            echo "Yellow SI: " . $hole->yellow_si;
            echo "White SI: " . $hole->white_si;


            echo "<br /> ";
        }
    }

    public function get_club_courses()
    {

    }

    /**
     * @param mixed $golfclub
     * @return bool     
     * 
     */
    public function add_golf_club( $golfclub )
    {
        $class_name = get_class($golfclub);
        if ( is_object($golfclub) ) 
        {
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

    public function add_club_courses()
    {

    } 

    public function updateGolfClub($club_ID) 

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

    public function editGolfClub($club_ID) 
    
    {
        /*
        $golf_club = $this->getGolfClubs($club_ID);
        //$this->populate_class($club_ID);
        if ($golf_club) {
            $this->setClubID($golf_club->getClubID());
            $this->setDateCreated($golf_club->getDateCreated());
            $this->setClubName($golf_club->getClubName());
            $this->setAboutClub($golf_club->getAboutClub());
            $this->setAddress1($golf_club->getAddress1());
            $this->setAddress2($golf_club->getAddress2());
            $this->setTownCity($golf_club->getTownCity());
            $this->setPostcode($golf_club->getPostcode());
            $this->setGps($golf_club->getGps());
            $this->setPhone($golf_club->getPhone());
            $this->setEmail($golf_club->getEmail());
            $this->setSocial($golf_club->getSocial());
        }
    
    */
    }
 
    public function insertGolfClub()

    {
        global $wpdb;
        $new_club_sql = "INSERT INTO `wp_golf_clubs` (`club_name`, `about_club`, `address_1`, `address_2`, `town`, `postcode`, `gps`, `phone`, `email`, `social`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)";
        $new_course_sql = "INSERT INTO `wp_golf_courses` ";
        $data = [
                    'club_name' => sanitize_text_field($this->club_name),
                    'about_club' => sanitize_textarea_field($this->about_club),
                    'address_1' => sanitize_text_field($this->address_1),
                    'address_2' => sanitize_text_field($this->address_2),
                    'town_city' => sanitize_text_field($this->town_city),
                    'postcode' => sanitize_text_field($this->postcode),
                    'gps' => sanitize_text_field($this->gps),
                    'phone' => sanitize_text_field($this->phone),
                    'email' => sanitize_email($this->email),
                    'social' => $this->social
                ];
        $results = $wpdb->query($wpdb->prepare($new_club_sql, $data));
        if ($results) {



            return $wpdb->insert_id;
        } else {
            return false;
        }
    }

    public function sayHello()

    {
        echo "Hello";
    }

    public function show_golf_club_submission()

    { 

        // Testing link for when I am logged on
        /*?><a href="<?php wp_login_url();  ?>" alt="Step Up To The Tee" id="login_button" class="login_button">Log In to add your Golf Course</a><?php
        */
        //Populate the class with values for the form from the properties
        $created_by = $this->getCreatedBy();
        if (!isset($created_by)) 
        $created_by = get_current_user_id();
        if ( $created_by > 0 )
        {
            $form = '<form id="submit-golfcourse" method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">
                ' . wp_nonce_field( 'my_action', 'my_nonce' ) . '
                <input type="hidden" name="action" value="club_form_submission">
                <input type="hidden" name="created_by" value="' . $created_by . '">
                
                <label>Club ID: ' . $this->getClubID() . '</label><br />
                <input type="hidden" name="club_ID" id="club_ID" value="' . $this->getClubID() . '">
                <label>Date Created: ' . substr($this->date_created, 0, 10) .  '<br />

                <label for="club_name">Club Name:</label>
                <input type="text" id="club_name" name="club_name" value="' . $this->getClubName() .  '"><br />

                <label for="about_club">About Club:</label>
                <textarea id="about_club" name="about_club">' . $this->getAboutClub() .  '</textarea><br />

                <label for="address_1">Address 1:</label>
                <input type="text" id="address_1" name="address_1" value="' . $this->getAddress1() .  '"><br />

                <label for="address_2">Address 2:</label>
                <input type="text" id="address_2" name="address_2" value="' . $this->getAddress2() .  '"><br />

                <label for="town_city">Town/City:</label>
                <input type="text" id="town_city" name="town_city" value="' . $this->getTownCity() .  '"><br />

                <label for="postcode">Postcode:</label>
                <input type="text" id="postcode" name="postcode" value="' . $this->getPostcode() .  '"><br />

                <label for="gps">GPS:</label>
                <input type="text" id="gps" name="gps" value="' . $this->getGps() .  '"><br />

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="' . $this->getPhone() .  '"><br />

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="' . $this->getEmail() .  '"><br />

                <label for="social">Social:</label>
                <input type="text" id="social" name="social" value="' . $this->getSocial() .  '"><br />

                <input type="submit" value="Submit">
            </form>';
            echo $form;
        } else {
            ?>
            <a href="<?php wp_login_url();  ?>" alt="Step Up To The Tee" id="login_button" class="login_button">Log In to add your Golf Course</a>
            <?php
        }
            
    }


    public function show_golf_club()

    {

            $post = get_post( $this->club_ID );
            
            //$this->pretty_print($post);
            $thumbnail_url = get_the_post_thumbnail_url($this->club_ID);
            $image_size = getimagesize( $thumbnail_url );

            //Output the width and height of the image
            //$width =  '100px';
            $width = ($image_size[0] * .1);
            //$height =  '100px';
            $height = ($image_size[1] * .1);
            $img =  '<img style="float:right;margin-left:20px" src="' . $thumbnail_url . '" alt="" width="' . $width . '" height="' . $width . '">';
        
        
        
    ?>
        <div id="clubcard" class="entry-content">
        <h1><?php echo $post->post_title; ?></h1>
        <?php echo $img; ?>
        <div><label>Club ID:<?php echo $this->getClubID()  ?> </label></div>
        <div><label>Date Created: <?php echo substr($this->date_created, 0, 10) ?>  </label></div>
        <div><label>Address: </label><?php echo $this->getAddress1() ?></div>

        <div><label>Address:</label><?php echo $this->getAddress2() ?></div>

        <div><label>City: </label><?php echo $this->getTownCity() ?></div>

        <div><label>Postcode: </label><?php echo $this->getPostcode() ?></div>

        <div><label>GPS: </label><?php echo $this->getGps() ?></div>

        <div><label>Phone: </label><?php echo $this->getPhone() ?></div>

        <div><label>Email: </label><?php echo $this->getEmail() ?></div>

        <div><label>Social: </label><?php echo $this->getSocial() ?></div>

        </div> 

    <?php
    }

    // Handle the golf club submission form
    public function BAK_club_form_submission() 
    
    {
        // Verify nonce
        if ( ! isset( $_POST['my_nonce'] ) || ! wp_verify_nonce( $_POST['my_nonce'], 'my_action' ) ) {
          return;
        }
        
        // Get form data
        $this->club_ID = $_POST['club_ID'];
        $this->club_name = sanitize_text_field( $_POST['club_name'] );
        $this->about_club = sanitize_textarea_field( $_POST['about_club'] );
        $this->address_1 = sanitize_text_field( $_POST['address_1'] );
        $this->address_2 = sanitize_text_field( $_POST['address_2'] );
        $this->town_city = sanitize_text_field( $_POST['town_city'] );
        $this->postcode = sanitize_text_field( $_POST['postcode'] );
        $this->gps = sanitize_text_field( $_POST['gps'] );
        $this->phone = sanitize_text_field( $_POST['phone'] );
        $this->email = sanitize_email( $_POST['email'] );
        $this->social = sanitize_text_field( $_POST['social'] );
        
        if ( $this->club_ID > 0 )
        {
            // we have a club so update
            $this->updateGolfClub( $this->club_ID );
        } else {
            // no club so insert a club
            $this->insertGolfClub();
        }
        
        // Redirect
        wp_redirect( home_url() );
        exit;
    }
    
    static function club_form_submission() 
    
    {
        global $_POST;

        // Verify nonce
        if ( ! isset( $_POST['my_nonce'] ) || ! wp_verify_nonce( $_POST['my_nonce'], 'my_action' ) ) {
          //return;
        }

        $golfClub = new pwgGolfClub($_POST['club_ID']);
        // Get form data
        //$club_ID = $_POST['club_ID'];
        $golfClub->club_ID = $_POST['club_ID'];
        $golfClub->created_by = $_POST['created_by'];
        $golfClub->club_name = sanitize_text_field( $_POST['club_name'] );
        $golfClub->about_club = sanitize_textarea_field( $_POST['about_club'] );
        $golfClub->address_1 = sanitize_text_field( $_POST['address_1'] );
        $golfClub->address_2 = sanitize_text_field( $_POST['address_2'] );
        $golfClub->town_city = sanitize_text_field( $_POST['town_city'] );
        $golfClub->postcode = sanitize_text_field( $_POST['postcode'] );
        $golfClub->gps = sanitize_text_field( $_POST['gps'] );
        $golfClub->phone = sanitize_text_field( $_POST['phone'] );
        $golfClub->email = sanitize_email( $_POST['email'] );
        $golfClub->social = sanitize_text_field( $_POST['social'] );
        
        if ( $golfClub->getClubID() > 0 )
        {
            // we have a club so update
            $golfClub->updateGolfClub($golfClub->getClubID());
        } else {
            // no club so insert a club
            $golfClub->insertGolfClub();
        }
        unset($golfClub);
        // Redirect
        wp_redirect( home_url() );
        exit;
    }    
    
    public function createClub ( $club_ID, $created_by, $date_created, $club_name, $about_club, $address_1, $address_2, $town_city, $postcode, $gps, $phone, $email, $social )

    {
        $this->setClubID( $club_ID );
        $this->setCreatedBy($created_by);
        $this->setDateCreated($date_created);
        $this->setClubName($club_name);
        $this->setAboutClub($about_club);
        $this->setAddress1($address_1);
        $this->setAddress2($address_2);
        $this->setTownCity($town_city);
        $this->setPostcode($postcode);
        $this->setGps($gps);
        $this->setPhone($phone);
        $this->setEmail($email);
        $this->setSocial($social);
        $this->insertGolfClub();

    }

    /** with the $club_ID fetch all the courses from wp_golf_courses
     * for each of the courses delete all the holes with the course_ID
     * for each course delete all courses with club_ID
     * finally delete the club
    */
    public function delete_golf_club($club_ID)
    {
        global $wpdb;
        
        $select_courses_sql ="SELECT `course_ID` FROM `wp_golf_courses` WHERE `club_ID` = %s";

        $delete_holes_sql="DELETE FROM `wp_holes` WHERE `course_ID` = %s";

        $delete_courses_sql ="DELETE FROM `wp_golf_courses` WHERE `course_ID` = %s";

        $delete_club_sql = "DELETE FROM `wp_golf_clubs` WHERE `club_ID` = %s";

        $club_ID =[$club_ID];



        // select all courses belonging to the club
        $courses = $wpdb->get_results($wpdb->prepare($select_courses_sql, $club_ID));
        $results=[];
        if ($courses) {
            // delete all holes with course_ID
            foreach ($courses as $course)
            {
                $results[] = $wpdb->query($wpdb->prepare($delete_holes_sql, [$course->course_ID]));
            }
            // delete all the courses
            foreach ($courses as $course)
            {
                $results[] = $wpdb->query($wpdb->prepare($delete_courses_sql, [$course->course_ID]));
            }
            
            $results[] = $wpdb->query($wpdb->prepare($delete_club_sql, $club_ID));
            return $results;
        } else {
            return false;
        }
    }

    public function pretty_print($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

    public function pretty_vardump($var)
    {
        echo '<pre>';
        var_dump($var);
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
    
    public function getClubID() {
        return $this->club_ID;
    }

    public function setClubID($club_ID) {
        $this->club_ID = $club_ID;
    }

    public function getCreatedBy() {
        return $this->created_by;
    }

    public function setCreatedBy($created_by){
        $this->created_by = $created_by;
    }

    public function getClubCourses() {
        return $this->club_courses;
    }

    public function setClubCourses($club_courses) {
        $this->club_courses = $club_courses;
    }

    public function getClubName() {
        return $this->club_name;
    }

    public function setClubName($club_name) {
        $this->club_name = $club_name;
    }

    public function getDateCreated() {
        return $this->date_created;
    }

    public function setDateCreated($date_created) {
        $this->date_created = $date_created;
    }

    public function getAboutClub() {
        return $this->about_club;
    }

    public function setAboutClub($about_club) {
        $this->about_club = $about_club;
    }

    public function getAddress1() {
        return $this->address_1;
    }

    public function setAddress1($address_1) {
        $this->address_1 = $address_1;
    }

    public function getAddress2() {
        return $this->address_2;
    }

    public function setAddress2($address_2) {
        $this->address_2 = $address_2;
    }

    public function getTownCity() {
        return $this->town_city;
    }

    public function setTownCity($town_city) {
        $this->town_city = $town_city;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    public function getGps() {
        return $this->gps;
    }

    public function setGps($gps) {
        $this->gps = $gps;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getSocial() {
        return $this->social;
    }

    public function setSocial($social) {
        $this->social = $social;
    }
    /////////////// End of Getters and Setters /////////////////////////////
}

