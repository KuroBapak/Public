<?php
$string2 = "I love PHP";

// Mengambil kata-kata pada string
$words = explode(" ", $string2);

// Menampilkan hasil
echo "<h3>Soal No 2</h3>";
echo "<label>String: </label> \"$string2\"<br>";
echo "Kata pertama: " . $words[0] . "<br>"; 
echo "Kata kedua: " . $words[1] . "<br>";
echo "Kata ketiga: " . $words[2] . "<br>";
?>
