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

        



        

        public function __construct($hole) {

            $this->populate_class($hole);

        }

        public function populate_class($holes)
        {
            global $wpdb;

            if ( is_object($holes))
            {

                $this->setHoles($holes);

            } else {
                
                $holeSQL = "SELECT  `hole_ID`, `number`, `name`, `white_yards`, `white_par`, `si_white`, `yellow_yards`, `yellow_par`, `si_yellow`, `red_yards`, `red_par`, `si_red`, `blue_yards`, `blue_par`, `si_blue` 
                FROM `wp_holes` 
                WHERE
                `course_ID` = %d
                ORDER BY `number`";

                $holes = $wpdb->get_results($wpdb->prepare($holeSQL, $holes), 'ARRAY_A');

                if ($holes) {
                    $this->setHoles($holes);
                    $split_arrays= array_chunk($holes, 9);
                    $this->setFrontNine($split_arrays[0]);
                    $this->setBackNine($split_arrays[1]);
                } 
                
            }
        }

        public function remove_scorecard_columns_NEW(array $columns) {
            $h =  array_diff($this->getHoles(), $columns);
            $this->setHoles( $h )  ;
            $this->setFrontNine( array_diff($this->getFrontNine(), $columns) );
            $this->setBackNine( array_diff($this->getBackNine(), $columns) );
        }
       

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
                        echo '<th class="blue_yards">Yds</th>';
                    break;

                    case 'red_yards' :
                        echo '<th class="red_yards">Yds</th>';
                    break;

                    case 'yellow_yards' :
                        echo '<th class="yellow_yards">Yds</th>';
                    break;

                    case 'white_yards' :
                        echo '<th class="white_yards">Yds</th>';
                    break;

                    case 'red_par' :
                        echo '<th class="red_par">Par</th>';
                    break;

                    case 'yellow_par' :
                        echo '<th class="yellow_par">Par</th>';
                    break;

                    case 'white_par' :
                        echo '<th class="white_par">Par</th>';
                    break;

                    case 'blue_par' :
                        echo '<th class="blue_par">Par</th>';
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

        public function build_table($which_holes = '')
        {
            //$columns_to_remove = [ 'name', 'white_yards', 'white_par', 'si_white', 'yellow_yards', 'yellow_par','si_yellow', 'blue_yards', 'blue_par', 'si_blue', 'red_yards', 'red_par', 'si_red'];
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
                        echo "<th class=''>$blue_yds_total</th>";
                    break;

                    case 'red_yards' :
                        echo "<th class=''$>$red_yds_total</th>";
                    break;

                    case 'yellow_yards' :
                        echo "<th class=''>$yellow_yds_total</th>";
                    break;

                    case 'white_yards' :
                        echo "<th class=''>$white_yds_total</th>";
                    break;

                    case 'red_par' :
                        echo "<th class=''>$red_par_total</th>";
                    break;

                    case 'yellow_par' :
                        echo "<th class=''>$yellow_par_total</th>";
                    break;

                    case 'white_par' :
                        echo "<th class=''>$white_par_total</th>";
                    break;

                    case 'blue_par' :
                        echo "<th class=''>$blue_par_total</th>";
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
                        echo "<th class=''>$blue_yds_total</th>";
                    break;

                    case 'red_yards' :
                        echo "<th class=''$>$red_yds_total</th>";
                    break;

                    case 'yellow_yards' :
                        echo "<th class=''>$yellow_yds_total</th>";
                    break;

                    case 'white_yards' :
                        echo "<th class=''>$white_yds_total</th>";
                    break;

                    case 'red_par' :
                        echo "<th class=''>$red_par_total</th>";
                    break;

                    case 'yellow_par' :
                        echo "<th class=''>$yellow_par_total</th>";
                    break;

                    case 'white_par' :
                        echo "<th class=''>$white_par_total</th>";
                    break;

                    case 'blue_par' :
                        echo "<th class=''>$blue_par_total</th>";
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

        public function loopThroughHoles() 
        {



            




        // echo '<table>';
        // foreach ($holes as $key => $hole) {
        //     echo '<tr>';
        //     foreach ($hole as $key2 => $hole_element)
        //     {
        //         echo "<td>" . $hole_element . "</td>";
        //         //echo $hole_element . '....<br />';
        //         // if ($key2 == 'pro_tip') 
        //         // {
        //         //     unset($holes[$key][$key2]);
        //         // }
        //     }
        //     echo '</tr>';
        //     $this->setHoles($holes);

        //     $holes = $this->getHoles();
        //     $numColumns = count($holes);

        //     // Output the scores to HTML.
        //     // echo "<table>";

        //     // foreach ( $holes as $key => $hole) {
        //     //     echo '<tr>';
        //     //     foreach( $hole as $key2 => $value)
        //     //     {
        //     //         echo "<td>" . $key2 . "</td>";

        //     //     }
        //     //     echo '</tr>';

                
        //     //     //echo "<td>" . $hole[$key] . "</td>";
        //     // }
        //     // echo "</table>";

        // // Remove the "blue yards" column from the array.
        // //array_pop($columns);

        // // Add the "red par" column after the "red yards" column.
        // //array_splice($columns, 1, 0, "red par");

        // // Remove the "white par" column from the array.
        
        //      //unset ($hole[$key]['name']) ;
        
            


        //     //echo "Hole {$hole['number']}: par {$hole['white_par']}, yardage {$hole['red_yards']}\n </br>
        //     //Pro Tip: {$hole['pro_tip']} <br /> Key is {$key} <br/>";
        // }
        // echo '</table>';
    }

    public function pretty_print($var)
    {
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