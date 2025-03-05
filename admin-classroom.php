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
    if (isset($_POST["select-year"])) {
        return 3;
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
            writeYears();
            break;
        case 3:
            writeClasses($_POST["select-year"]);
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

function getYears() {
    $conn = ConnectDB("schoolbook");
    $result = Years($conn);
    $years = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $years[] = $row["year"];
        }
    }
    $conn->close();
    return $years;
}

function getClasses($y) {
    $conn = ConnectDB("schoolbook");
    $result = Classes($conn, $y);
    $classes = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $classes[$row["id"]] = $row["code"];
        }
    }
    $conn->close();
    return $classes;
}