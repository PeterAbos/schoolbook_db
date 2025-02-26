<?php

require_once "classroom-data.php";
require_once "lekerdezes.php";

function getData() {
    return DATA;
}


function FillDatabase($conn) {
    $data = getData();

    //Subject tábla feltöltése:
    $subjects = $data["subjects"];
    for($i = 0; $i < count($subjects); $i++) {
        InsertToSubjects($conn, $i+1, $subjects[$i]);
    }

    $classes = $data["classes"];
    $class_year = [];
    for($i = 0; $i < count($classes); $i++) {
        $randomYear = random_int(2020, 2024);
        InsertToClasses($conn, $i+1, $classes[$i], (string)$randomYear);
        $class_year[$classes[$i]] = $randomYear;
    }
    $lnames = $data["lastnames"];
    $fnames = $data["firstnames"];
    $idCounter = 1;
    foreach ($classes as $c) {
        $classYear = $class_year[$c];
        $classNum = random_int(10, 20);
        for ($i = 0; $i < $classNum; $i++) {
            //Egy diák létrehozása
            $gNum = random_int(0, 1);
            $gender = $gNum == 1 ? "men" : "women";
            $lnameIndex = random_int(0, count($lnames)-1);
            $fnamesG = $fnames[$gender];
            $fnameIndex = random_int(0, count($fnamesG)-1);
            $Name = $lnames[$lnameIndex]." ".$fnamesG[$fnameIndex];
            InsertToStudents($conn, $Name, $gNum, $c, $classYear);

            //A diák tantárgyankénti jegyeinek létrehozásas
            foreach ($subjects as $subject) {
                $gradeNum = random_int(1, 5);
                for ($j = 0; $j < $gradeNum; $j++) {
                    $randomGrade = random_int(1, 5);
                    $date = date('Y-m-d');
                    $y = random_int(0, 1);
                    if ($y) {
                        $rMonth = random_int(1, 5);
                    } else {
                        $rMonth = random_int(9, 12);
                    }
                    $rDay = random_int(1, 31);
                    $date = ($classYear+$y)."-".$rMonth."-".$rDay;
                    InsertToGrades($conn, $idCounter, $subject, $randomGrade, $date);
                }
            }

            $idCounter++;
        }
    }
}

function MakeDB() {
    $conn = ConnectDB("");
    CreateDB($conn);
    $conn->close();
    $conn = ConnectDB("schoolbook");
    AddTableStudent($conn);
    AddTableClasses($conn);
    AddTableSubjects($conn);
    AddTableGrades($conn);

    FillDatabase($conn);
    $conn->close();
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
            $classes[] = $row["code"];
        }
    }
    $conn->close();
    return $classes;
}

function getYear() {
    $years = getYears();
    foreach ($years as $y) {
        if (isset($_POST["btn-$y"])) {
            return $y;
        }
    }
    return -1;
}

function getClass() {
    if (!isset($_SESSION["classes"])) {
        return -1;
    }
    $classes = $_SESSION["classes"];
    foreach ($classes as $c) {
        if (isset($_POST["btn-$c"])) {
            return $c;
        }
    }
    return -1;
    
}

function getStudents($class) {
    $conn = ConnectDB("schoolbook");
    $result = Students($conn, $class);
    $students = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $students[$row["id"]] = $row["name"];
        }
    }
    $conn->close();
    return $students;
}