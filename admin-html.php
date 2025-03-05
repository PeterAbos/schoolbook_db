<?php

require_once "admin-classroom.php";

function htmlBody() {
    echo "<form action='' method='post'>";

    echo "<button name='btn-subjects'>Tantárgyak</button>";
    echo "<button name='btn-classes'>Osztályok</button>";

    echo "</form>";
}

function subjectsCRUDHtml() {
    echo "Tantárgyak módosítása";

    $subjects = getSubjects();

    echo "<form action='' method='post'>";
    echo "<table border=1>";
    echo "<caption><button name='new-sub'>Új tantárgy</button></td></caption>";
    foreach ($subjects as $id => $subject) {
        echo "<tr>";
        echo "<td>$subject</td>";
        echo "<td><button name='change-sub' value='$id'>Módosítás</button></td>";
        echo "<td><button name='delete-sub' value='$id'>Törlés</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</form>";
}

function writeYears() {
    echo "Osztályok módosítása";

    $years = getYears();

    echo "<form action='' method='post'>";
    foreach ($years as $y) {
        echo "<button name='select-year' value=$y>$y</button>";
    }
    echo "</form>";
}

function writeClasses($y) {
    $classes = getClasses($y);

    echo "<h2>Osztályok ebben az évben: $y</h2>";
    echo "<form action='' method='post'>";
    echo "<table border=1>";
    echo "<caption><button name='new-class'>Új osztály</button></caption>";
    foreach ($classes as $id => $class) {
        echo "<tr>";
        echo "<td>$class</td>";
        echo "<td><button name='change-class' value='$id'>Módosítás</button></td>";
        echo "<td><button name='delete-class' value='$id'>Törlés</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</form>";
}

function newSubject() {
    echo "<form action='' method='post'>";
    echo "<input type='text' name='new-sub-name'>";
    echo "<button name='add-new-sub'>Hozzáadás</button>";
    echo "</form>";
}

function changeSubject($v, $name) {
    echo "<form action='' method='post'>";
    echo "<input type='text' name='sub-changed-name' value='$name'>";
    echo "<button name='change-sub-submit' value='$v'>Módosít</button>";
    echo "</form>";
}