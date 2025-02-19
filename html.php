<?php

require_once "classroom.php";

function HTMLBody() {
    $years = getYears();
    echo "<form method='post' action=''>";
    echo "<select name='dropdown' onchange=''>";
    echo "<option value=''>Válassz egy évfolyamot...</option>";
    foreach ($years as $y) {
        echo "<option value='$y'>$y</option>";
    }
    echo "</select>";
    echo "</form>";
}

