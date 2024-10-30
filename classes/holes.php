<?php 

    class Holes {

        private $holes;
        private $front_nine;
        private $back_nine;

        private $hole_ID;
        
        private $course_ID;
        private $number;
        private $name;
        private $pro_tip;
        private $blue_yards;
        private $red_yards;
        private $yellow_yards;
        private $white_yards;
        private $red_par;
        private $yellow_par;
        private $white_par;
        private $blue_par;
        private $si_red;
        private $si_yellow;
        private $si_white;
        private $si_blue;


        /**
         * At the moment it is populating properties $holes, $front_nine and $back_nine with arrays
         * @param $hole int or array() 
         */
        public function __construct() {

            // if (is_int($hole)) {
            //     // this will populate $holes, $front_nine $back_nine from database
            //     $this->populate_class($hole);
            //     $this->pretty_print($this);
            // } elseif(is_array($hole)) {
            //     // populate single hole from array
            //     $this->setCourseID($hole['course_ID']);
            //     $this->setNumber($hole['number']);
            //     $this->setName($hole['name']);
            //     $this->setProTip($hole['pro_tip']);
            //     $this->setBlueYards($hole['blue_yards']);
            //     $this->setRedYards($hole['red_yards']);
            //     $this->setYellowYards($hole['yellow_yards']);
            //     $this->setWhiteYards($hole['white_yards']);
            //     $this->setBluePar($hole['blue_par']);
            //     $this->setRedPar($hole['red_par']);
            //     $this->setYellowPar($hole['yellow_par']);
            //     $this->setWhitePar($hole['white_par']);
            //     $this->setSiBlue($hole['si_blue']);
            //     $this->setSiRed($hole['si_red']);
            //     $this->setSiYellow($hole['si_yellow']);
            //     $this->setSiWhite($hole['si_white']);
            // }
            

        }

        /**
         * Inserts one hole into the database 
         * 
         * Development Note: Should/could be passed an array of holes 
         * but can be passed each hole one by one from an outside function
         * as an array of $args in populate_class()
         * 
         * 
         */
        public function inserHole(){

            $args = [

                'course_ID' => $this->getCourseID(),
                'hole_number' => $this->getNumber(),
                'hole_name' => $this->getName(),
                'pro_tip' => $this->getProTip(),
                'blue_yards' => $this->getBlueYards(),
                'red_yards' => $this->getRedYards(),
                'yellow_yards' => $this->getYellowYards(),
                'white_yards' => $this->getWhiteYards(),
                'blue_par' => $this->getBluePar(),
                'red_par' => $this->getRedPar(),
                'yellow_par' => $this->getYellowPar(),
                'white_par' => $this->getWhitePar(),
                'si_blue'=> $this->getSiBlue(),
                'si_red' => $this->getSiRed(),
                'si_yellow' => $this->getSiYellow(),
                'si_white' => $this->getSiYellow()
            ];

            $formats = [
                '%d', '%d', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d',
            ];
            global $wpdb;
            $results = $wpdb->insert('wp_holes', $args, $formats);

            if ($results) {
                return $wpdb->insert_id;
            } else {
                return false;
            }

            // this needs to use $wpdb->query
        }

        public function insert_hole($args){

            $formats = [
                '%d', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d'
            ];
            global $wpdb;
            $results = $wpdb->insert('wp_holes', $args, $formats);

            if ($results) {
                return $wpdb->insert_id;
            } else {
                return false;
            }

            // this needs to use $wpdb->query
        }


        /**
         * function to quickly insert holes with only a course_ID and the number of holes
         */
        public static function insertHoleNumbers($course_ID, $number){

            global $wpdb;

            $preparedSQL = $wpdb->prepare(
                "INSERT INTO `wp_holes` (`course_ID`, `number`) VALUES (%d, %d)", 
                $course_ID, $number  
                );
                
                $wpdb->query($preparedSQL);
                return $wpdb->insert_ID;

        }

        /**
         * Populates the class with the holes of a golfcourse
         * 
         * Development Note: Not sure why an object would be passed
         * I must have had something in mind 
         */
        public function populate_class_by_object($holes_object)
        {
            
            if ( is_object($holes_object))
            {
                // convert object to array
                $holes = get_object_vars($holes_object);
                $this->setHoles($holes);

            }
        }

        public function populate_class_by_ID($hole_ID){

            global $wpdb;
                
                $holeSQL = "SELECT  `hole_ID`, `number`, `name`, `white_yards`, `white_par`, `si_white`, `yellow_yards`, `yellow_par`, `si_yellow`, `red_yards`, `red_par`, `si_red`, `blue_yards`, `blue_par`, `si_blue` 
                FROM `wp_holes` 
                WHERE
                `course_ID` = %d
                ORDER BY `number`";

                $holes = $wpdb->get_results($wpdb->prepare($holeSQL, $hole_ID), 'ARRAY_A');

                if ($holes) {
                    $this->setHoles($holes);
                    $split_arrays= array_chunk($holes, 9);
                    $this->setFrontNine($split_arrays[0]);
                    $this->setBackNine($split_arrays[1]);
                } 

        }

        /**
         * @param [$columns] an array of columns to remove from the prperty $holes
         * Development Note: could and should be used to remove them from $front_nine and $back_nine
         */
        public function remove_scorecard_columns( array $columns )
        {
            $holes = $this->getHoles();
            foreach ($holes as $key => $hole) {
                foreach ($hole as $key2 => $hole_element)
                {
                    foreach ($columns as $column => $value){  
                        if ($key2 == $value) 
                        {
                            unset($holes[$key][$key2]);
                        }
                    }

                    
                }
            
            $this->setHoles($holes);
            //$holes= $this->getHoles();

            }


            $holes = $this->getFrontNine();
            foreach ($holes as $key => $hole) {
                foreach ($hole as $key2 => $hole_element)
                {
                    foreach ($columns as $column => $value){  
                        if ($key2 == $value) 
                        {
                            unset($holes[$key][$key2]);
                        }
                    }

                    
                }
            
            $this->setFrontNine($holes);
            //$holes= $this->getHoles();

            }


            $holes = $this->getBackNine();
            foreach ($holes as $key => $hole) {
                foreach ($hole as $key2 => $hole_element)
                {
                    foreach ($columns as $column => $value){  
                        if ($key2 == $value) 
                        {
                            unset($holes[$key][$key2]);
                        }
                    }

                    
                }
            
            $this->setBackNine($holes);
            //$holes= $this->getHoles();

            }

        }

        public function build_scorecard_head()
        {
            $holes = $this->getHoles();

            echo '<table>';
            
            $hole = $holes[0];
            echo '<tr>';
            foreach ( $hole as $key => $value)
            {
                switch ($key) 
                {
                    
                    case 'number' :
                        echo '<th>#</th>';
                    break;

                    case 'name' :
                        echo '<th>Name</th>';
                    break;

                    case 'blue_yards' :
                        echo '<th class="blue">Yds</th>';
                    break;

                    case 'red_yards' :
                        echo '<th class="red">Yds</th>';
                    break;

                    case 'yellow_yards' :
                        echo '<th class="yellow">Yds</th>';
                    break;

                    case 'white_yards' :
                        echo '<th class="white">Yds</th>';
                    break;

                    case 'red_par' :
                        echo '<th class="red">Par</th>';
                    break;

                    case 'yellow_par' :
                        echo '<th class="yellow">Par</th>';
                    break;

                    case 'white_par' :
                        echo '<th class="white">Par</th>';
                    break;

                    case 'blue_par' :
                        echo '<th class="blue">Par</th>';
                    break;

                    case 'si_red' :
                        echo '<th class="red">SI</th>';
                    break;

                    case 'si_yellow' :
                        echo '<th class="yellow">SI</th>';
                    break;

                    case 'si_white' :
                        echo '<th class="white">SI</th>';
                    break;

                    case 'si_blue' :
                        echo '<th class="blue">SI</th>';
                    break;

                }
                //echo '<td>' . $key . '</td>';
            }
            echo '</tr>';
        }

        /**
         * Builds out a table showing the score card of a course
         * @param $which_holes can be 'front_nine' 'back_nine' or if left blank
         * will display both front and back holes
         * 
         * Development Note: Should be passed an array of columns to remove
         * from property $holes which holds the holes array of the course 
         * @param $key the hole number
         * @param $key2 is the database field names and 
         * @param $value is the value returned
         * 
         * Uses function remove_scorecard_columns() to remove columns from the table
         * @array $columns_to_remove = [ 'name', 'white_yards', 'white_par', 'si_white', 'yellow_yards', 'yellow_par','si_yellow', 'blue_yards', 'blue_par', 'si_blue', 'red_yards', 'red_par', 'si_red'];
         * 
         * Uses function build_scorecard_head()
         * Development Note: I did this to tidy up or abstract out functionality
         * It is used in the middle of building a table so can not be used on it's own
         * as it only builds table rows
         */
        public function build_table($which_holes = '')
        {
            
            $columns_to_remove = [ 'si_white','si_yellow', 'si_blue', 'si_red', 'blue_yards', 'blue_par'];
            $this->remove_scorecard_columns($columns_to_remove);

            switch ($which_holes)
            {
                case 'front_nine' :
                    $holes = $this->getFrontNine();
                break;

                case 'back_nine' :
                    $holes = $this->getBackNine();
                break;

                default :
                $holes = $this->getHoles();
                break;
            }


            //$holes = $this->getHoles();
            $this->build_scorecard_head();


            $red_yds_total = 0;
            $red_par_total = 0;
            $yellow_par_total = 0;
            $yellow_yds_total = 0;

            $white_par_total = 0;
            $white_yds_total = 0;

            $blue_par_total = 0;
            $blue_yds_total = 0;
            //echo '<table>';
            foreach ( $holes as $key => $hole) {

                if ( $key == 9)
                {
                    echo '<tr class="totals">';
            foreach ( $hole as $key => $value)
            {
                switch ($key) 
                {
                    case 'hole_ID':
                        break;
                    case 'number' :
                        echo '<th></th>';
                    break;

                    case 'name' :
                        echo '<th>Front Nine</th>';
                    break;

                    case 'blue_yards' :
                        echo "<th class='blue'>$blue_yds_total</th>";
                    break;

                    case 'red_yards' :
                        echo "<th class='red'>$red_yds_total</th>";
                    break;

                    case 'yellow_yards' :
                        echo "<th class='yellow'>$yellow_yds_total</th>";
                    break;

                    case 'white_yards' :
                        echo "<th class='white'>$white_yds_total</th>";
                    break;

                    case 'red_par' :
                        echo "<th class='red'>$red_par_total</th>";
                    break;

                    case 'yellow_par' :
                        echo "<th class='yellow'>$yellow_par_total</th>";
                    break;

                    case 'white_par' :
                        echo "<th class='white'>$white_par_total</th>";
                    break;

                    case 'blue_par' :
                        echo "<th class='blue'>$blue_par_total</th>";
                    break;

                    case 'si_red' :
                        echo '<th class="red"></th>';
                    break;

                    case 'si_yellow' :
                        echo '<th class="yellow"></th>';
                    break;

                    case 'si_white' :
                        echo '<th class="white"></th>';
                    break;

                    case 'si_blue' :
                        echo '<th class="blue"></th>';
                    break;

                }
                //echo '<td>' . $key . '</td>';
            }
            echo '</tr>';
                }
                
                 echo '<tr>';
                 foreach( $hole as $key2 => $value)
                 {
                    switch ($key2) 
                    {
                        case 'red_yards':
                            $red_yds_total += $value;
                        break;
                        case 'red_par':
                            $red_par_total += $value;
                        break;


                        case 'yellow_yards':
                            $yellow_yds_total += $value;
                        break;
                        case 'yellow_par':
                            $yellow_par_total += $value;
                        break;

                        case 'blue_yards':
                            $blue_yds_total += $value;
                        break;
                        case 'blue_par':
                            $blue_par_total += $value;
                        break;

                        case 'white_yards':
                            $white_yds_total += $value;
                        break;
                        case 'white_par':
                            $white_par_total += $value;
                        break;
                        
                    }
                    
                    if ( $key2 == 'hole_ID')
                    {
                        echo "<input name='hole_ID_$value' type='hidden' value='$value'>";
                    } else {
                        echo "<td class='$key2'>$value </td>";
                    }
        
                 }
                 echo '</tr>';
                }


            echo '<tr class="totals">';
            foreach ( $hole as $key => $value)
            {
                switch ($key) 
                {
                    case 'hole_ID':
                        break;
                    case 'number' :
                        echo '<th></th>';
                    break;

                    case 'name' :
                        echo '<th></th>';
                    break;

                    case 'blue_yards' :
                        echo "<th class='blue'>$blue_yds_total</th>";
                    break;

                    case 'red_yards' :
                        echo "<th class='red'>$red_yds_total</th>";
                    break;

                    case 'yellow_yards' :
                        echo "<th class='yellow'>$yellow_yds_total</th>";
                    break;

                    case 'white_yards' :
                        echo "<th class='white'>$white_yds_total</th>";
                    break;

                    case 'red_par' :
                        echo "<th class='red'>$red_par_total</th>";
                    break;

                    case 'yellow_par' :
                        echo "<th class='yellow'>$yellow_par_total</th>";
                    break;

                    case 'white_par' :
                        echo "<th class='white'>$white_par_total</th>";
                    break;

                    case 'blue_par' :
                        echo "<th class='blue'>$blue_par_total</th>";
                    break;

                    case 'si_red' :
                        echo '<th class="red"></th>';
                    break;

                    case 'si_yellow' :
                        echo '<th class="yellow"></th>';
                    break;

                    case 'si_white' :
                        echo '<th class="white"></th>';
                    break;

                    case 'si_blue' :
                        echo '<th class="blue"></th>';
                    break;

                }
                //echo '<td>' . $key . '</td>';
            }
            echo '</tr>';



            echo '</table>';
        }

    
        // used for debugging to print out variables, arrays and objects
        public function pretty_print($var){
            echo '<pre>';
            print_r($var);
            echo '</pre>';
        }

    /////////// SETTERS AND GETTERS ///////////////////////

        public function getFrontNine() 
        {
            return $this->front_nine;
        }

        public function setFrontNine($front_nine) 
        {
            $this->front_nine = $front_nine;
        }

        public function getBackNine() 
        {
            return $this->back_nine;
        }

        public function setBackNine($back_nine) 
        {
            $this->back_nine = $back_nine;
        }
    
        public function getHoleID() 
        {
            return $this->hole_ID;
        }
    
        public function setHoleID($hole_ID) 
        {
            $this->hole_ID = $hole_ID;
        }
    
        public function getCourseID() 
        {
            return $this->course_ID;
        }
    
        public function setCourseID($course_ID) 
        {
            $this->course_ID = $course_ID;
        }

        

        public function getHoles() 
        {
            return $this->holes;
        }
    
        public function setHoles($holes) 
        {
            $this->holes = $holes;
        }
    
        public function getNumber() 
        {
            return $this->number;
        }
    
        public function setNumber($number) 
        {
            $this->number = $number;
        }
    
        public function getName() 
        {
            return $this->name;
        }
    
        public function setName($name) 
        {
            $this->name = $name;
        }
    
        public function getProTip() 
        {
            return $this->pro_tip;
        }
    
        public function setProTip($pro_tip) 
        {
            $this->pro_tip = $pro_tip;
        }
    
        public function getBlueYards() 
        {
            return $this->blue_yards;
        }
    
        public function setBlueYards($blue_yards) 
        {
            $this->blue_yards = $blue_yards;
        }
    
        public function getRedYards() 
        {
            return $this->red_yards;
        }
    
        public function setRedYards($red_yards) 
        {
            $this->red_yards = $red_yards;
        }

        
        public function getYellowYards() 
        {
            return $this->yellow_yards;
        }
    
        public function setYellowYards($yellow_yards) 
        {
            $this->yellow_yards = $yellow_yards;
        }
    
        public function getWhiteYards() 
        {
            return $this->white_yards;
        }
    
        public function setWhiteYards($white_yards) 
        {
            $this->white_yards = $white_yards;
        }
    
        public function getRedPar() 
        {
            return $this->red_par;
        }
    
        public function setRedPar($red_par) 
        {
            $this->red_par = $red_par;
        }
    
        public function getYellowPar() 
        {
            return $this->yellow_par;
        }
    
        public function setYellowPar($yellow_par) 
        {
            $this->yellow_par = $yellow_par;
        }
    
        public function getWhitePar() 
        {
            return $this->white_par;
        }
    
        public function setWhitePar($white_par) 
        {
            $this->white_par = $white_par;
        }
    
        public function getBluePar() 
        {
            return $this->blue_par;
        }
    
        public function setBluePar($blue_par) 
        {
            $this->blue_par = $blue_par;
        }
    
        public function getSiRed() 
        {
            return $this->si_red;
        }
    
        public function setSiRed($si_red) 
        {
            $this->si_red = $si_red;
        }
    
        public function getSiYellow() 
        {
            return $this->si_yellow;
        }
    
        public function setSiYellow($si_yellow) 
        {
            $this->si_yellow = $si_yellow;
        }
    
        public function getSiWhite() 
        {
            return $this->si_white;
        }
    
        public function setSiWhite($si_white) 
        {
            $this->si_white = $si_white;
        }
    
        public function getSiBlue() 
        {
            return $this->si_blue;
        }

        public function setSiBlue($si_blue) 
        {
            $this->si_white = $si_blue;
        }
    
    /////////// END OF SETTERS AND GETTERS ///////////////////////
    }