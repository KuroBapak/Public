<?php
require_once 'Animal.php';
require_once 'Frog.php';
require_once 'Ape.php';

$sheep = new Animal("shaun");
echo "Name: " . $sheep->getName() . "<br>";
echo "legs: " . $sheep->getLegs() . "<br>";
echo "cold blooded: " . $sheep->getColdBlooded() . "<br>";
echo "<br>";

$kodok = new Frog("buduk");
echo "Name: " . $kodok->getName() . "<br>";
echo "legs: " . $kodok->getLegs() . "<br>";
echo "cold blooded: " . $kodok->getColdBlooded() . "<br>";
echo "Jump: " . $kodok->jump() . "<br>";
echo "<br>";

$sungokong = new Ape("kera sakti");
echo "Name: " . $sungokong->getName() . "<br>";
echo "legs: " . $sungokong->getLegs() . "<br>";
echo "cold blooded: " . $sungokong->getColdBlooded() . "<br>";
echo "Yell: " . $sungokong->yell() . "<br>";
?>
