<?php
require_once 'Animal.php';

class Ape extends Animal {
    public function yell() {
        return "Auooo";
    }

    public function getLegs() {
        return 2;
    }
}
?>
