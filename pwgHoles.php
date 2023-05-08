<?php 

    class pwgHoles {

        
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


    /////////// SETTERS AND GETTERS ///////////////////////
    
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