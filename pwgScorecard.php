<?php

class Scorecard {

    private $player_1;
    private $player_2;
    private $player_3;
    private $player_4;


    public function getPlayer1()
    {
        return $this->player_1;
    }

    public function setPlayer1($player_1)
    {
        $this->$player_1 = $player_1;
    }

    public function getPlayer2()
    {
        return $this->player_2;
    }

    public function setPlayer2($player_2)
    {
        $this->$player_2 = $player_2;
    }

    public function getPlayer3()
    {
        return $this->player_3;
    }

    public function setPlayer3($player_3)
    {
        $this->$player_3 = $player_3;
    }

    public function getPlayer4()
    {
        return $this->player_4;
    }

    public function setPlayer4($player_4)
    {
        $this->$player_4 = $player_4;
    }
}