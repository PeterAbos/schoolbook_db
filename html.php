<?php

require_once "classroom.php";

function HTMLBody() {
    echo "<form method='post' action=''>";
    echo "<table>";
    echo "<tr>";
    writeYears();
    echo "</tr>";
    echo "<tr>";
    writeClasses(getYear());
    echo "</tr>";
    echo "</table>";
    echo "</form>";
}

function writeYears() {
    $years = getYears();
    foreach ($years as $y) {
        echo "<td><button name='btn-$y'>$y</button></td>";
    }
}

function writeClasses($y) {
    if ($y == -1) {
        return;
    }
    $classes = getClasses($y);
    foreach ($classes as $c) {
        echo "<td><button name='btn-$c'>$c</button></td>";
        if (isset($_POST["btn-$c"])) {
            echo "Megnyomva: $c";
        }
    }
}