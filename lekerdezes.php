<?php

$db = [
    "server"=>"localhost",
    "user"=>"root",
    "pw"=>"",
    "name"=>""
];

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

function FillDatabase($conn) {
    
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
}

/*Itt van egy mókás szöveeg hihihihihihi*/