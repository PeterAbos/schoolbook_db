<?php

require_once "classroom.php";

function HTMLBody() {
    $years = getYears();
    echo "<form method='post' action=''>";
    echo "<table border=2>";
    echo "<tr>";
    foreach ($years as $y) {
        echo "<td><button name='btn-$y'>$y</button></td>";
    }
    echo "</tr>";
    echo "</table>";
    echo "</form>";
}

