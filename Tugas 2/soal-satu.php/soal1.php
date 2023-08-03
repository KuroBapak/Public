<?php
$first_sentence = "Hello PHP!";
$second_sentence = "I'm ready for the challenges";

// Menghitung panjang string dan jumlah kata pada kalimat pertama
$panjang_string1 = strlen($first_sentence);
$jumlah_kata1 = str_word_count($first_sentence);

// Menghitung panjang string dan jumlah kata pada kalimat kedua
$panjang_string2 = strlen($second_sentence);
$jumlah_kata2 = str_word_count($second_sentence);

// Menampilkan hasil
echo "<h3>Soal No 1</h3>";
echo "Kalimat 1: \"$first_sentence\"<br>";
echo "Panjang string: $panjang_string1<br>";
echo "Jumlah kata: $jumlah_kata1<br>";

echo "Kalimat 2: \"$second_sentence\"<br>";
echo "Panjang string: $panjang_string2<br>";
echo "Jumlah kata: $jumlah_kata2<br>";
?>
