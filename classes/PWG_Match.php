<?php

//require_once(PWG_PLUGIN_DIR . '/classes/golfCourse.php');
class PWG_Match
{
    private $match_ID;
    private $user_ID;
    private $players = [];
    private $scores = [];
    private $date_played;
    private $course_ID;
    private PWG_GolfCourse $course;
    private $match_type;

    public function __construct($match_ID = 0, $course_ID = 0)
    {
        if ($match_ID === 0) {
            // new match
            $wp_user = wp_get_current_user();
            $this->addPlayer(new PWG_Golfer($wp_user));
            $this->setCourse_ID($course_ID);
            $course_ID = $this->getCourse_ID();
            $this->setCourse(new PWG_GolfCourse($course_ID));
            $this->generateScores();
        } else {
            global $wpdb;
            // retrieve match 
            $match_sql = 'SELECT 
                match_ID, 
                match_type, 
                course_ID, 
                date_played, 
                FROM ' . $wpdb->prefix . 'matches
                WHERE match_ID = ' . $match_ID;

            $match_details = $wpdb->get_results($match_sql);

            $this->setMatch_ID($match_details->match_ID);
            $this->setMatchType($match_details->match_type);
            $this->setCourse_ID($match_details->course_ID);
            $this->setCourse(new PWG_GolfCourse($this->getCourse_ID()));
            $this->setDatePlayed($match_details->date_played);

            $player_score_sql = 'SELECT 
                    match_score_ID, 
                    match_ID, 
                    user_ID, 
                    hole_scores, 
                    total_score, 
                    match_handicap
                    FROM ' . $wpdb->prefix . 'match_scores
                    WHERE match_ID = ' . $match_ID;

            $player_score_details = $wpdb->get_results($player_score_sql);

            foreach ($player_score_details as $player_ID => $score) {
                $this->players[] = new PWG_Golfer(get_user_by('User_ID', $player_ID));
                $this->scores[] = $score;
            }
        }
    }

    // public function show_leaderboard(){
    //     echo "Leaderboard:\n</br>";
    //     $leaderboard = $this->getLeaderboard();
    //     $players = $this->getPlayers();

    //     foreach ($leaderboard as $user_ID => $score) {
    //         $golfer = null;
    //         foreach ($players as $p) {
    //             if ($p->get_ID() == $user_ID) {
    //                 $golfer = $p;
    //                 break;
    //             }
    //         }
    //     }

    //     if ($golfer) {
    //         echo "{$golfer->get_friendly_name()}({$golfer->get_handicap()}): Gross {$score['gross']}, Net {$score['net']}\n" . "</br>";
    //     } else {
    //         echo "Unknown player (ID: $user_ID): Gross {$score['gross']}, Net {$score['net']}\n";
    //     }
    // }

    public function show_leaderboard()
    {
        echo "Leaderboard:\n</br>";
        $leaderboard = $this->getLeaderboard();
        $players = $this->getPlayers();

        foreach ($leaderboard as $user_ID => $score) {
            $golfer = null;
            foreach ($players as $p) {
                if ($p->get_ID() == $user_ID) {
                    $golfer = $p;
                    break;
                }
            }

            if ($golfer) {
                echo "({ $golfer->get_friendly_name( $golfer->get_ID  ) })({$golfer->get_handicap()}): Gross {$score['gross']}, Net {$score['net']}\n" . "</br>";
            } else {
                echo "Unknown player (ID: $user_ID): Gross {$score['gross']}, Net {$score['net']}\n";
            }
        }
    }

    function insert_golf_score($match_id, $user_id, $hole_scores, $total_score, $match_handicap)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'match_scores';

        // Ensure hole_scores is a valid JSON string
        $hole_scores_json = wp_json_encode($hole_scores);
        if ($hole_scores_json === false) {
            return new WP_Error('invalid_json', 'Invalid hole scores data');
        }

        // $result = $wpdb->insert(
        //     $table_name,
        //     array(
        //         'match_ID' => $this->match_ID,
        //         'user_ID' => $this->user_ID,
        //         'hole_scores' => $this->scores,
        //         'total_score' => $this->total_score,
        //         'match_handicap' => $this->match_handicap
        //     ),
        //     array(
        //         '%d', // match_ID
        //         '%d', // user_ID
        //         '%s', // hole_scores (JSON)
        //         '%d', // total_score
        //         '%f'  // match_handicap
        //     )
        // );

        // if ($result === false) {
        //     return new WP_Error('db_insert_error', $wpdb->last_error);
        // }

        // return $wpdb->insert_id;
    }



    public function addPlayer(PWG_Golfer $golfer)
    {
        $this->players[] = $golfer;
        $this->scores[$golfer->get_ID()] = [
            'score' => array_fill(1, 18, 0),
            'gross' => 0,
            'net' => 0
        ];
    }

    public function generateScores()
    {
        foreach ($this->players as $golfer) {
            for ($hole = 1; $hole <= 18; $hole++) {
                $this->scores[$golfer->get_ID()]['score'][$hole] = rand(3, 8);
            }
            $this->scores[$golfer->get_ID()]['gross'] = array_sum($this->scores[$golfer->get_ID()]['score']);
            $this->scores[$golfer->get_ID()]['net'] = $this->scores[$golfer->get_ID()]['gross'] - $golfer->get_handicap();
        }
    }

    public function getPlayerScore(PWG_Golfer $golfer)
    {
        return $this->scores[$golfer->get_ID()];
    }

    public function getLeaderboard()
    {
        $leaderboard = $this->scores;
        uasort($leaderboard, function ($a, $b) {
            return $a['net'] - $b['net'];
        });
        return $leaderboard;
    }

    public function setScore(PWG_Golfer $golfer, $hole, $score)
    {
        if ($hole < 1 || $hole > 18) {
            throw new InvalidArgumentException("Invalid hole number");
        }
        if ($score < 1) {
            throw new InvalidArgumentException("Invalid score");
        }
        $this->scores[$golfer->get_ID()]['score'][$hole] = $score;
        $this->updateTotals($golfer);
    }

    private function updateTotals(PWG_Golfer $golfer)
    {
        $userID = $golfer->get_ID();
        $this->scores[$userID]['gross'] = array_sum($this->scores[$userID]['score']);
        $this->scores[$userID]['net'] = $this->scores[$userID]['gross'] - $golfer->get_handicap();
    }

    // Getters

    public function getPlayers()
    {
        return $this->players;
    }

    public function getMatchType()
    {
        return $this->match_type;
    }

    public function getDatePlayed()
    {
        return $this->date_played;
    }

    public function getCourse_ID()
    {
        return $this->course_ID;
    }

    public function getMatch_ID()
    {
        return $this->match_ID;
    }

    public function getCourse()
    {
        return $this->course;
    }

    // Setters

    public function setMatchType($match_type)
    {
        $this->match_type = $match_type;
    }

    public function setDatePlayed($date_played)
    {
        $this->date_played = $date_played;
    }

    public function setCourse_ID($course_ID)
    {
        $this->course_ID = $course_ID;
    }

    public function setUser_ID($user_ID)
    {
        $this->user_ID = $user_ID;
    }

    public function setMatch_ID($match_ID)
    {
        $this->match_ID = $match_ID;
    }

    public function setCourse(PWG_GolfCourse $course)
    {
        $this->course = $course;
    }
}
