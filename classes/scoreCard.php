<?php


class Scorecard {

    private $scores = [];
    private $holes = ["number", "white yards", "white par", "white SI", "yellow yards", "yellow par", "yellow SI", "red yards", "red par", "red SI", "blue yards", "blue par", "blue SI"] ;

    public function __construct() {
        $this->scores = array_fill(0, 4, 0);
    }

    public function swap_columns()
    {
        // Remove the "blue yards" column from the array.
        //array_pop($columns);

        // Add the "red par" column after the "red yards" column.
        //array_splice($columns, 1, 0, "red par");

        // Remove the "white par" column from the array.
        //array_splice($columns, 3, 1);

        // Determine the number of columns in the array.
        $holes = $this->getHoles();
        $numColumns = count($holes);

        // Output the scores to HTML.
        echo "<table>";
        for ($i = 0; $i < $numColumns; $i++) {
            echo "<td>" . $holes[$i] . "</td>";
        }
        echo "</table>";
    }

    public function addHoles($holes) {
        $this->holes= $holes;
    }

    public function getHoles() {
        return $this->holes;
    }

    public function addScore($player, $score) {
        $this->scores[$player] = $score;
    }

    public function getScores() {
        return $this->scores;
    }

    public function sortScores() {
        asort($this->scores);
    }

    public function outputScores() {
        echo "<table>";
        foreach ($this->scores as $player => $score) {
            echo "<tr><td>$player</td><td>$score</td></tr>";
        }
        echo "</table>";
    }
}
