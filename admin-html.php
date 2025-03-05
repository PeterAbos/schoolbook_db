<?php
function htmlBody() {
    echo "<form action='' method='post'>";

    echo "<button name='btn-subjects'>Tantárgyak</button>";
    echo "<button name='btn-classes'>Osztályok</button>";

    echo "</form>";
}

function subjectsCRUD() {
    echo "Tantárgyak módosítása";
}

function classesCRUD() {
    echo "Osztályok módosítása";
}