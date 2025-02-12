<?php

$db = [
    "server"=>"localhost",
    "user"=>"root",
    "pw"=>"",
    "name"=>""
];

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

/*Itt van egy mókás szöveeg hihihihihihi*/