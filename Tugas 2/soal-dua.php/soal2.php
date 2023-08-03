<?php
echo "<h3>Soal 2</h3>";
/* 
        SOAL NO 2
        Tunjukkan panjang Array di Soal No 1 dan tampilkan isi dari masing-masing Array.
    */
$kids = array("Mike", "Dustin", "Will", "Lucas", "Max", "Eleven");
$adults = array("Hopper", "Nancy",  "Joyce", "Jonathan", "Murray");

echo "Cast Stranger Things: ";
echo "<br>";
echo "Total Kids: " . count($kids) . "<br>"; // Berapa panjang array kids
echo "<ol>";
foreach ($kids as $kid) {
    echo "<li>$kid</li>";
}
echo "</ol>";

echo "Total Adults: " . count($adults) . "<br>"; // Berapa panjang array adults
echo "<ol>";
foreach ($adults as $adult) {
    echo "<li>$adult</li>";
}
echo "</ol>";
?>
