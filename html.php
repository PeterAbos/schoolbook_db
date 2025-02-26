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
    $_SESSION["classes"] = $classes;
    foreach ($classes as $c) {
        echo "<td><button name='btn-$c'>$c</button></td>";
        if (isset($_POST["btn-$c"])) {
            echo "Megnyomva: $c";
        }
    }
}

function writeAClass($class) {
    if ($class == -1) {
        return;
    }
    $students = getStudents($class);
    echo "<h2>$class</h2>";
    echo "<table border=2>";
    foreach ($students as $s) {
        echo "<tr><td>{$s}</td></tr>";
    }
    echo "</table>";
}