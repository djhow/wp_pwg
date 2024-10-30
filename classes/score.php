<?php

class Score {

    private $score_ID;
    private $course_ID;
    private $marker_ID;
    private $match_ID;
    private $total;
    private $course_pars;
    private $par_total;
    private $score_array = [];
    private $course_SI;
   
    private $player_ID;
    private $handicap;
    private $tees_played;
    
    

    private $score_1;
    private $score_2;
    private $score_3;
    private $score_4;
    private $score_5;
    private $score_6;
    private $score_7;
    private $score_8;
    private $score_9;
    private $score_10;
    private $score_11;
    private $score_12;
    private $score_13;
    private $score_14;
    private $score_15;
    private $score_16;
    private $score_17;
    private $score_18;

    
    

    public function __construct($score_ID)
    {
        $this->populate_class($score_ID);
    }


    public function populate_class($score_ID)
    {
        global $wpdb;
        $score_sql = "SELECT *
            FROM `wp_scores` 
            WHERE `score_ID` = %d ";

            $score = $wpdb->get_row($wpdb->prepare($score_sql, $score_ID));
            // print_r($golfcourse);
            if ($score)
            {
                $score_array = [];
                foreach ( $score as $key => $value)
                {
                    switch ($key) 
                    {
                        case 'score_ID' :
                            $this->setScore_ID($value);
                        break;
                        
                        case 'handicap' :
                            $this->setHandicap($value);
                        break;
                        
                        case 'tees_played' :
                            $this->setTeesPlayed($value);
                        break;

                        case 'score_ID' :
                            $this->setScore_ID($value);
                        break;

                        case 'course_ID' :
                            $this->setCourse_ID($value);
                        break;

                        case 'marker_ID' :
                            $this->setMarker_ID($value);
                        break;

                        case 'player_ID' :
                            $this->setPlayer_ID($value);
                        break;

                        case 'match_ID' :
                            $this->setMatch_ID($value);
                        break;

                        case 'score_1' :
                            $this->setScore1($value);
                            $score_array[1] =  $value;
                        break;

                        case 'score_2' :
                            $this->setScore2($value);
                            $score_array[2] = $value;
                        break;

                        case 'score_3' :
                            $this->setScore3($value);
                            $score_array[3] = $value;
                        break;

                        case 'score_4' :
                            $this->setScore4($value);
                            $score_array[4] = $value;
                        break;

                        case 'score_5' :
                            $this->setScore5($value);
                            $score_array[5] = $value;
                        break;

                        case 'score_6' :
                            $this->setScore6($value);
                            $score_array[6] = $value;
                        break;

                        case 'score_7' :
                            $this->setScore7($value);
                            $score_array[7] = $value;
                        break;

                        case 'score_8' :
                            $this->setScore8($value);
                            $score_array[8] = $value;
                        break;

                        case 'score_9' :
                            $this->setScore9($value);
                            $score_array[9] = $value;
                        break;

                        case 'score_10' :
                            $this->setScore10($value);
                            $score_array[10] = $value;
                        break;

                        case 'score_11' :
                            $this->setScore11($value);
                            $score_array[11] = $value;
                        break;

                        case 'score_12' :
                            $this->setScore12($value);
                            $score_array[12] = $value;
                        break;

                        case 'score_13' :
                            $this->setScore13($value);
                            $score_array[13] = $value;
                        break;

                        case 'score_14' :
                            $this->setScore14($value);
                            $score_array[14] = $value;
                        break;

                        case 'score_15' :
                            $this->setScore15($value);
                            $score_array[15] = $value;
                        break;

                        case 'score_16' :
                            $this->setScore16($value);
                            $score_array[16] = $value;
                        break;

                        case 'score_17' :
                            $this->setScore17($value);
                            $score_array[17] = $value;
                        break;

                        case 'score_18' :
                            $this->setScore18($value);
                            $score_array[18] = $value;
                        break;
                    
                    }
                    $this->setScoreArray($score_array);
                    $this->setTotal(array_sum($score_array));
                }


                $par_SQL = "SELECT `yellow_par` 
                            FROM `wp_holes` 
                            WHERE `course_ID` = %d";
                            $course_ID = $this->getCourse_ID();
                $pars = $wpdb->get_results($wpdb->prepare($par_SQL, $course_ID));
                $pars_array = [];
                $x = 1;
                foreach ( $pars as $par)
                {
                    $pars_array[$x] = $par->yellow_par;
                    $x++;
                }


                $this->setCoursePars($pars_array);
                $this->setParTotal(array_sum($pars_array));
                
            }
    }

    public function get_players_own_score($player_ID)
    {

    }

    public function update_score_by_score_ID(int $score_ID = 0)
    {
        if ($score_ID > 0)
        {

        
            global $wpdb;
            $score_ID = $this->getScore_ID();
            $score_SQL ="UPDATE `wp_scores`
                        SET
                        `course_ID` = %d,
                        `marker_ID` = %d,
                        `player_ID` = %d,
                        `match_ID` = %d,
                        `score_1` = %d,
                        `score_2` = %d,
                        `score_3` = %d,
                        `score_4` = %d,
                        `score_5` = %d,
                        `score_6` = %d,
                        `score_7` = %d,
                        `score_8` = %d,
                        `score_9` = %d,
                        `score_10` = %d,
                        `score_11` = %d,
                        `score_12` = %d,
                        `score_13` = %d,
                        `score_14` = %d,
                        `score_15` = %d,
                        `score_16` = %d,
                        `score_17` = %d,
                        `score_18` = %d
                        WHERE `score_ID` = $score_ID ";

            $results = $wpdb->query($wpdb->prepare(
                $score_SQL,
                $this->getCourse_ID(),
                $this->getMarker_ID(),
                $this->getPlayer_ID(),
                $this->getMatch_ID(),
                $this->getScore1(),
                $this->getScore2(),
                $this->getScore3(),
                $this->getScore4(),
                $this->getScore5(),
                $this->getScore6(),
                $this->getScore7(),
                $this->getScore8(),
                $this->getScore9(),
                $this->getScore10(),
                $this->getScore11(),
                $this->getScore12(),
                $this->getScore13(),
                $this->getScore14(),
                $this->getScore15(),
                $this->getScore16(),
                $this->getScore17(),
                $this->getScore18()
            ));
        }
    }

    public function insert_score()
    {
        global $wpdb;
        $score_SQL = "INSERT INTO `wp_scores` (
            `course_ID`,
            `marker_ID`,
            `player_ID`,
            `match_ID`,
            `score_1`,
            `score_2`,
            `score_3`,
            `score_4`,
            `score_5`,
            `score_6`,
            `score_7`,
            `score_8`,
            `score_9`,
            `score_10`,
            `score_11`,
            `score_12`,
            `score_13`,
            `score_14`,
            `score_15`,
            `score_16`,
            `score_17`,
            `score_18`
            ) VALUES (
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d,
                %d
            )";
        $data= [
            'course_ID' => sanitize_text_field($this->getCourse_ID()),
            'marker_ID' => sanitize_text_field($this->getMarker_ID()),
            'player_ID' => sanitize_text_field($this->getPlayer_ID()),
            'match_ID' => sanitize_text_field($this->getMatch_ID()),
            'score_1' => sanitize_text_field($this->getScore1()),
            'score_2' => sanitize_text_field($this->getScore2()),
            'score_3' => sanitize_text_field($this->getScore3()),
            'score_4' => sanitize_text_field($this->getScore4()),
            'score_5' => sanitize_text_field($this->getScore5()),
            'score_6' => sanitize_text_field($this->getScore6()),
            'score_7' => sanitize_text_field($this->getScore7()),
            'score_8' => sanitize_text_field($this->getScore8()),
            'score_9' => sanitize_text_field($this->getScore9()),
            'score_10' => sanitize_text_field($this->getScore10()),
            'score_11' => sanitize_text_field($this->getScore11()),
            'score_12' => sanitize_text_field($this->getScore12()),
            'score_13' => sanitize_text_field($this->getScore13()),
            'score_14' => sanitize_text_field($this->getScore14()),
            'score_15' => sanitize_text_field($this->getScore15()),
            'score_16' => sanitize_text_field($this->getScore16()),
            'score_17' => sanitize_text_field($this->getScore17()),
            'score_18' => sanitize_text_field($this->getScore18())
        ];

        $results = $wpdb->query($wpdb->prepare($score_SQL, $data));
        if ($results) {
            return $wpdb->insert_id;
        } else {
            return false;
        }
    }

    public function edit_score()
    {
        $scores = $this->getScoreArray();
        $pars = $this->getCoursePars();
    
        echo "<table>";
        echo "<tr><td>#</td>";

        foreach ($pars as $key => $par)
        {
            echo "<td>$key</td>";
        }

        echo "</tr>";

        echo "<tr><td>Par</td>";
        foreach ($pars as $key => $par)
        {
            echo "<td>$par</td>";
        }
        echo "</tr>";

        echo "<tr><td>Score</td>";
        foreach ($scores as $key => $score)
        {
            echo "<td><input min='1' style='width: 60px' type='number' value='$score'></td>";
        }

        echo "</tr>";



        echo "</table>";


    
    }

    public function list_score()
    {
        $scores = $this->getScoreArray();
        echo "<ul class='score-container'>";
        foreach($scores as $key => $value)
        {
            echo "<li class='score'>$value</li>";
        }
        echo "</ul>";

        $pars = $this->getCoursePars();
        echo "<ul class='score-container'>";
        foreach($pars as $key => $value)
        {
            echo "<li class='score'>$value</li>";
        }
        echo "</ul>";
    }

    public function pretty_print($var)
    {
        echo print_r($var);
    }



////////////////////// GETTERS AND SETTERS \\\\\\\\\\\\\\\\\\\\\\\\\\\


    public function getTeesPlayed()
    {
        return $this->tees_played;
    }

    public function setTeesPlayed($tees_played)
    {
        $this->tees_played = $tees_played;
    }

    public function getHandicap()
    {
        return $this->handicap;
    }

    public function setHandicap($handicap)
    {
        $this->handicap = $handicap;
    }

    public function getCourseSI()
    {
        return $this->course_SI;
    }

    public function setCourseSI($course_SI)
    {
        $this->course_SI = $course_SI;
    }

    public function getParTotal()
    {
        return $this->par_total;
    }

    public function setParTotal($par_total)
    {
        $this->par_total = $par_total;
    }

    public function getCoursePars()
    {
        return $this->course_pars;
    }

    public function setCoursePars($pars)
    {
        $this->course_pars = $pars;
    }
    

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getScoreArray()
    {
        return $this->score_array;
    }

    public function setScoreArray($array)
    {
        $this->score_array = $array;
    }

    public function getCourse_ID() {
        return $this->course_ID;
    }

    public function setCourse_ID($course_ID) {
        $this->course_ID = $course_ID;
    }

    public function getScore_ID() {
        return $this->score_ID;
    }

    public function setScore_ID($score_ID) {
        $this->score_ID = $score_ID;
    }

    public function getMarker_ID() {
        return $this->marker_ID;
    }

    public function setMarker_ID($marker_ID) {
        $this->marker_ID = $marker_ID;
    }

    public function getPlayer_ID() {
        return $this->player_ID;
    }

    public function setPlayer_ID($player_ID) {
        $this->player_ID = $player_ID;
    }

    public function getMatch_ID() {
        return $this->match_ID;
    }

    public function setMatch_ID($match_ID) {
        $this->match_ID = $match_ID;
    }

    public function getScore1() {
        return $this->score_1;
    }

    public function setScore1($score_1) {
        $this->score_1 = $score_1;
    }

    public function getScore2() {
        return $this->score_2;
    }

    public function setScore2($score_2) {
        $this->score_2 = $score_2;
    }

    public function getScore3() {
        return $this->score_3;
    }

    public function setScore3($score_3) {
        $this->score_3 = $score_3;
    }

    public function getScore4() {
        return $this->score_4;
    }

    public function setScore4($score_4) {
        $this->score_4 = $score_4;
    }

    public function getScore5() {
        return $this->score_5;
    }

    public function setScore5($score_5) {
        $this->score_5 = $score_5;
    }

    public function getScore6() {
        return $this->score_6;
    }

    public function setScore6($score_6) {
        $this->score_6 = $score_6;
    }

    public function getScore7() {
        return $this->score_7;
    }

    public function setScore7($score_7) {
        $this->score_7 = $score_7;
    }

    public function getScore8() {
        return $this->score_8;
    }

    public function setScore8($score_8) {
        $this->score_8 = $score_8;
    }

    public function getScore9() {
        return $this->score_9;
    }

    public function setScore9($score_9) {
        $this->score_9 = $score_9;
    }

    public function getScore10() {
        return $this->score_10;
    }

    public function setScore10($score_10) {
        $this->score_10 = $score_10;
    }

    public function getScore11() {
        return $this->score_11;
    }

    public function setScore11($score_11) {
        $this->score_11 = $score_11;
    }

    public function getScore12() {
        return $this->score_12;
    }

    public function setScore12($score_12) {
        $this->score_12 = $score_12;
    }

    public function getScore13() {
        return $this->score_13;
    }

    public function setScore13($score_13) {
        $this->score_13 = $score_13;
    }

    public function getScore14() {
        return $this->score_14;
    }

    public function setScore14($score_14) {
        $this->score_14 = $score_14;
    }

    public function getScore15() {
        return $this->score_15;
    }

    public function setScore15($score_15) {
        $this->score_15 = $score_15;
    }

    public function getScore16() {
        return $this->score_16;
    }

    public function setScore16($score_16) {
        $this->score_16 = $score_16;
    }

    public function getScore17() {
        return $this->score_17;
    }

    public function setScore17($score_17) {
        $this->score_17 = $score_17;
    }

    public function getScore18() {
        return $this->score_18;
    }

    public function setScore18($score_18) {
        $this->score_18 = $score_18;
    }
}
