<?php

function ConnectDB($dbName) {
    $conn = new mysqli("localhost", "root", "", $dbName);

    return $conn;
}

function CreateDB($conn) {
    $result = $conn->query(
     "CREATE DATABASE IF NOT EXISTS `schoolbook`
      DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci ;");
}

function AddTableStudent($conn) {
    $result = $conn->query(
     "CREATE TABLE IF NOT EXISTS `students` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	gender INT,
	class_id INT
    )");
}

function AddTableClasses($conn) {
    $result = $conn->query(
    "CREATE TABLE IF NOT EXISTS `classes` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	code VARCHAR(3),
	year YEAR
    )");
}

function AddTableSubjects($conn) {
    $result = $conn->query(
    "CREATE TABLE IF NOT EXISTS `subjects` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(20) NOT NULL
    )");
}

function AddTableGrades($conn) {
    $result = $conn->query(
    "CREATE TABLE IF NOT EXISTS `grades` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	student_id INT,
	subject_id INT,
	grade INT,
	date DATE
    )");
}

function InsertToSubjects($conn, $id, $name) {
    $conn->query(
    "INSERT IGNORE INTO subjects(id, name)
    VALUES ($id, '$name')");
}
function InsertToClasses($conn, $id, $name, $year) {
    $conn->query( 
    "INSERT IGNORE INTO classes(id, code, year)
    VALUES ($id, '$name', '$year')");
}

function InsertToStudents($conn, $name, $gender, $class) {
    $conn->query( 
    "INSERT INTO students(name, gender, class_id)
    VALUES ('$name', '$gender', (SELECT id
                                    FROM classes
                                    WHERE code='$class'))");
}

function InsertToGrades($conn, $id, $subject, $grade, $date) {
    $conn->query(
    "INSERT INTO grades(student_id, subject_id, grade, date)
     VALUES ('$id', (SELECT id FROM subjects WHERE name='$subject'), '$grade', '$date')");
}

function DBExists($dbname, $host = "localhost", $user = "root", $password = "") {
    $mysqli = new mysqli($host, $user, $password);
    
    if ($mysqli->connect_error) {
        return false;
    }
    
    $result = $mysqli->query("SHOW DATABASES LIKE '$dbname'");
    $exists = $result && $result->num_rows > 0;
    
    $mysqli->close();
    return $exists;
}

/*Itt van egy mókás szöveeg hihihihihihi*/