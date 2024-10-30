<?php





class GolfCourse {

    private $holes;

    public function __construct() {
        $this->holes = [
            'hole-1' => [
                'par' => 4,
                'yardage' => 400
            ],
            'hole-2' => [
                'par' => 3,
                'yardage' => 150
            ],
            'hole-3' => [
                'par' => 5,
                'yardage' => 500
            ]
        ];
    }

    public function getHoles() {
        return $this->holes;
    }

    public function loopThroughHoles() {
        foreach ($this->holes as $holeName => $holeDetails) {
            echo "Hole {$holeName}: par {$holeDetails['par']}, yardage {$holeDetails['yardage']}\n";
        }
    }
}

$golfCourse = new GolfCourse(); print_r($golfcourse);
$golfCourse->loopThroughHoles();
