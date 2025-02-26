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
    writeClassAVG(getYear());
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

function writeClassAVG($y) {
    $classAVG = getClassAVG();
    if ($classAVG == -1) {
        return;
    }
    echo "<table border=2>";
    foreach ($classAVG as $c => $avg) {
        echo "<tr><th colspan=2>$c</th></tr>";
        echo "<tr><td>AVG</td><td>$avg</td></tr>";
        $avgs = getClassAVGSub($c);
        foreach ($avgs as $s => $a) {
            echo "<tr><td>$s</td><td>$a</td></tr>";
        }
    }
    echo "</table>";
}

function writeAClass($class) {
    if ($class == -1) {
        return;
    }
    $students = getStudents($class);
    echo "<h2>$class</h2>";
    echo "<table>";
    foreach ($students as $id => $s) {
        echo "<tr>";
        echo "<table border=2 style='margin: 10'>";
        echo "<th colspan=2>$s</th>";
        $things = getStudentThings($id);
        foreach ($things as $t => $avg) {
            echo "<tr>";
            echo "<td>$t</td>";
            echo "<td>$avg</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</tr>";
        

    }
    echo "</table>";
}