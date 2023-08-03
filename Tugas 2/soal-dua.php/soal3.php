<?php

echo "<h3> Soal No 3</h3>";

    $trainer = array (
        array("Name" => "Will Byers",
              "Age" => 12,
              "Aliases" => "Will the Wise",
              "Status" => "Alive"),

        array("Name" => "Mike Wheeler",
              "Age" => 12,
              "Aliases" => "Dungeon Master",
              "Status" => "Alive"),
          
        array("Name" => "Jim Hooper",
              "Age" => 43,
              "Aliases" => "Chief Hopper",
              "Status" => "Deceased"),
        array("Name" => "Eleven",
              "Age" => 12,
              "Aliases" => "El",
              "Status" => "Alive"),
        );
  
            echo "<pre>";
            print_r($trainer);
            echo "</pre>";
?>