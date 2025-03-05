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
    echo "<table>";
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

function classesCRUDHtml() {
    echo "Osztályok módosítása";
}