<?php

class golfMatch 
{
    private $match_ID;
    private $player_1;
    private $player_2;
    private $player_3;
    private $player_4;
    private $course_ID;
    private $date_played;
    private $status;
    private $last_updated;

    public function populate_class($match_ID = 0)
    {
        if ($match_ID > 0 )
        {
            global $wpdb;

            $match_SQL = "SELECT * FROM `wp_matches` WHERE `match_ID` = %d";
            $match = $wpdb->get_row($wpdb->prepare($match_SQL, $match_ID));
            if ($match) 
            {
                foreach ($match as $key => $value)
                {

                
                    switch ($key)
                    {
                        case 'match_ID' :
                            $this->setMatchID($value);
                        break;

                        case 'player_1' :
                            $this->setPlayer1($value);
                        break;

                        case 'player_2' :
                            $this->setPlayer2($value);
                        break;

                        case 'player_3' :
                            $this->setPlayer3($value);
                        break;

                        case 'player_4' :
                            $this->setPlayer4($value);
                        break;

                        case 'course_ID' :
                            $this->setCourseID($value);
                        break;

                        case 'date_played' :
                            $this->setdatePlayed($value);
                        break;

                        case 'status' :
                            $this->setStatus($value);
                        break;

                        case 'last_updated' :
                            $this->setlastUpdated($value);
                        break;
                    }

                }
            }
        }

    }

    public function update_match()
    {
        global $wpdb;
        $match_SQL = "UPDATE `wp_matches`
        SET
        `player_1` = %d,
        `player_2` = %d,
        `player_3` = %d,
        `player_4` = %d,
        `course_ID` = %d,
        `date_played` = %d,
        `status` = %s ";

        $results = $wpdb->query($wpdb->prepare(
            $match_SQL,
            $this->getPlayer1(),
            $this->getPlayer2(),
            $this->getPlayer3(),
            $this->getPlayer4(),
            $this->getCourseID(),
            $this->getdatePlayed(),
            $this->getStatus()
        ));
    }

    //////////////////////// Setters and Getters \\\\\\\\\\\\\\\\\\\\\\\\

    public function setMatchID($match_ID)
    {
        $this->match_ID = $match_ID;
    }

    public function getMatchID()
    {
        return $this->match_ID;
    }

    public function setPlayer1($player_1)
    {
        $this->player_1 = $player_1;
    }

    public function getPlayer1()
    {
        return $this->player_1;
    }

    public function setPlayer2($player_2)
    {
        $this->player_2 = $player_2;
    }

    public function getPlayer2()
    {
        return $this->player_2;
    }

    public function setPlayer3($player_3)
    {
        $this->player_3 = $player_3;
    }

    public function getPlayer3()
    {
        return $this->player_3;
    }

    public function setPlayer4($player_4)
    {
        $this->player_4 = $player_4;
    }

    public function getPlayer4()
    {
        return $this->player_4;
    }

    public function setCourseID($course_ID)
    {
        $this->course_ID = $course_ID;
    }

    public function getCourseID()
    {
        return $this->course_ID;
    }

    public function setdatePlayed($date_played)
    {
        $this->date_played = $date_played;
    }

    public function getdatePlayed()
    {
        return $this->date_played;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setlastUpdated($last_updated)
    {
        $this->last_updated = $last_updated;
    }

    public function getlastUpdated()
    {
        return $this->last_updated;
    }

}