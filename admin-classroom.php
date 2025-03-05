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
    if (isset($_POST["new-sub"])) {
        return 4;
    }
    if (isset($_POST["add-new-sub"])) {
        return 5;
    }
    if (isset($_POST["change-sub"])) {
        return 6;
    }
    if (isset($_POST["change-sub-submit"])) {
        return 7;
    }
    if (isset($_POST["delete-sub"])) {
        return 8;
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
        case 4:
            newSubject();
            break;
        case 5:
            $sub = $_POST["new-sub-name"];
            $conn = ConnectDB('schoolbook');
            InsertToSubjects($conn, $sub);
            $conn->close();
            break;
        case 6:
            changeSubject($_POST["change-sub"], getSubjectById($_POST["change-sub"]));
            break;
        case 7:
            $newName = $_POST["sub-changed-name"];
            $id = $_POST["change-sub-submit"];
            changeSubjectById($id, $newName);
            setPage(1);
            break;
        case 8:
            $id = $_POST["delete-sub"];
            deleteSubjectById($id);
            setPage(1);
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