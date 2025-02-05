<?php

require_once 'classroom-data.php';

$db = [
    "server"=>"localhost",
    "user"=>"root",
    "pw"=>"",
    "name"=>""
];

function getData() {
    return DATA;
}

function HTMLBody() {
    echo "Csatlakozás";
    echo "<form name='nav' method='post' action=''>";
    echo "<button name='conn-btn'>csatlakozás</button>";
    echo "</form>";
}

function ConnectDB($db) {
    $conn = mysqli_connect($db["server"], $db["user"], $db["pw"], $db["name"]);

    if($conn){
        echo "Sikeres csatlakozás";
    }
    else {
        echo "Csatlakozás sikertelen";
    }
    return $conn;
}

function CreateDB($conn) {
    $result = mysqli_query($conn,
     "CREATE DATABASE IF NOT EXISTS `schoolbook`
      DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci ;");
}

function AddTableStudent($conn) {
    $result = mysqli_query($conn,
     "CREATE TABLE IF NOT EXISTS `students` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	gender INT,
	class_id INT
    )");
}

function AddTableClasses($conn) {
    $result = mysqli_query($conn,
    "CREATE TABLE IF NOT EXISTS `classes` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	code VARCHAR(3),
	year YEAR
    )");
}

function AddTableSubjects($conn) {
    $result = mysqli_query($conn,
    "CREATE TABLE IF NOT EXISTS `subjects` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(20) NOT NULL
    )");
}

function AddTableGrades($conn) {
    $result = mysqli_query($conn,
    "CREATE TABLE IF NOT EXISTS `grades` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	student_id INT,
	subject_id INT,
	grade INT,
	date DATE
    )");
}

function InsertToSubjects($conn, $id, $name) {
    mysqli_query($conn, 
    "INSERT IGNORE INTO subjects(id, name)
    VALUES ($id, '$name')");
}
function InsertToClasses($conn, $id, $name, $year) {
    mysqli_query($conn, 
    "INSERT IGNORE INTO classes(id, code, year)
    VALUES ($id, '$name', '$year')");
}

function InsertToStudents($conn, $name, $gender, $class) {
    mysqli_query($conn, 
    "INSERT INTO students(name, gender, class_id)
    VALUES ('$name', '$gender', (SELECT id
                                    FROM classes
                                    WHERE code='$class'))");
}

function InsertToGrades($conn, $id, $subject, $grade, $date) {
    mysqli_query($conn, 
    "INSERT INTO grades(student_id, subject_id, grade, date)
     VALUES ('$id', (SELECT id FROM subjects WHERE name='$subject'), '$grade', '$date')");
}

function FillDatabase($conn) {
    $data = getData();

    //Subject tábla feltöltése:
    $subjects = $data["subjects"];
    for($i = 0; $i < count($subjects); $i++) {
        InsertToSubjects($conn, $i+1, $subjects[$i]);
    }

    //Classes tábla feltöltése
    $classes = $data["classes"];
    for($i = 0; $i < count($classes); $i++) {
        InsertToClasses($conn, $i+1, $classes[$i], "2025");
    }

    //Students és Grades tábla feltöltése
    $lnames = $data["lastnames"];
    $fnames = $data["firstnames"];
    $idCounter = 1;
    foreach ($classes as $c) {
        $classNum = random_int(10, 20);
        for ($i = 0; $i < $classNum; $i++) {
            //Egy diák létrehozása
            $gNum = random_int(0, 1);
            $gender = $gNum == 1 ? "men" : "women";
            $lnameIndex = random_int(0, count($lnames)-1);
            $fnamesG = $fnames[$gender];
            $fnameIndex = random_int(0, count($fnamesG)-1);
            $Name = $lnames[$lnameIndex]." ".$fnamesG[$fnameIndex];
            InsertToStudents($conn, $Name, $gNum, $c);

            //A diák tantárgyankénti jegyeinek létrehozásas
            foreach ($subjects as $subject) {
                $gradeNum = random_int(1, 5);
                for ($j = 0; $j < $gradeNum; $j++) {
                    $randomGrade = random_int(1, 5);
                    InsertToGrades($conn, $idCounter, $subject, $randomGrade, "2025-02-05");
                }
            }

            $idCounter++;
        }
    }
}


HTMLBody();
if(isset($_POST["conn-btn"])) {
    $conn = ConnectDB($db);
    CreateDB($conn);
    $db["name"] = "schoolbook";
    $conn = ConnectDB($db);
    AddTableStudent($conn);
    AddTableClasses($conn);
    AddTableSubjects($conn);
    AddTableGrades($conn);

    FillDatabase($conn);
}

/*Itt van egy mókás szöveeg hihihihihihi*/