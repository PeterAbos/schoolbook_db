<?php

function ConnectDB($dbName) {
    $conn = new mysqli("localhost", "root", "", $dbName);

    return $conn;
}

function dropDB($dbName) {
    $conn = ConnectDB("");

    $conn->query("DROP DATABASE $dbName");

    $conn->close();
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
    "INSERT IGNORE INTO classes(code, year)
    VALUES ('$name', '$year')");
}

function InsertToStudents($conn, $name, $gender, $class, $year) {
    $conn->query( 
    "INSERT INTO students(name, gender, class_id)
    VALUES ('$name', '$gender', (SELECT id
                                    FROM classes
                                    WHERE code='$class' AND year='$year'))");
}

function InsertToGrades($conn, $id, $subject, $grade, $date) {
    $conn->query(
    "INSERT INTO grades(student_id, subject_id, grade, date)
     VALUES ($id, 
     (SELECT id FROM subjects WHERE name='$subject'), 
     '$grade', '$date')");
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


function Years($conn) {
    

    $sql = "SELECT year
            FROM classes
            GROUP BY year
            ORDER BY 1";

    $result = $conn->query($sql);

    return $result;

}

function Classes($conn, $y) {
    

    $sql = "SELECT code
            FROM classes
            WHERE year=$y
            ORDER BY 1";

    $result = $conn->query($sql);

    return $result;

}

function Students($conn, $class) {
    $sql = "SELECT s.name 'name'
            FROM students s
            JOIN classes c ON s.class_id=c.id
            WHERE c.code='$class'";

    $result = $conn->query($sql);

    return $result;
}

/*Itt van egy mókás szöveeg hihihihihihi*/