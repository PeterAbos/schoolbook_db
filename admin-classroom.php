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
            subjectsCRUDHtml();
            break;
        case 2:
            classesCRUDHtml();
            break;
    }
}

function getSubjects() {
    $conn = ConnectDB("schoolbook");
    $result = subjectsSQL($conn);
    $subjects = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $subjects[$row["id"]] = $row["name"];
        }
    }
    $conn->close();
    return $subjects;
}