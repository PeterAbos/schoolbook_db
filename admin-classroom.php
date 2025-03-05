<?php

require_once "admin-html.php";
require_once "lekerdezes.php";

function getBtnPost() {
    if (isset($_POST["btn-subjects"])) {
        return 1;
    }
    if (isset($_POST["btn-classes"])) {
        return 2;
    }
    return false;
}

function setPage($version) {
    if (!$version) { return; }
    switch ($version) {
        case 1:
            subjectsCRUD();
            break;
        case 2:
            classesCRUD();
            break;
    }
}