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

function InsertToSubjects($conn, $name) {
    $conn->query(
    "INSERT IGNORE INTO subjects(name)
    VALUES ('$name')");
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
    

    $sql = "SELECT id, code
            FROM classes
            WHERE year=$y
            ORDER BY 1";

    $result = $conn->query($sql);

    return $result;

}

function Students($conn, $class) {
    $sql = "SELECT s.id as id, s.name as 'name'
            FROM students s
            JOIN classes c ON s.class_id=c.id
            WHERE c.code='$class'
            ORDER BY 2";

    $result = $conn->query($sql);

    return $result;
}

function classAVG($conn, $class) {
    $sql = "SELECT h.osztaly as osztaly, ROUND(AVG(h.atlag), 2) as atlag
            FROM (SELECT t.osztaly as osztaly, t.nev, AVG(t.atlag) as atlag
                    FROM (SELECT c.code as osztaly, st.id as id, st.name as nev, su.name, AVG(g.grade) as atlag
                            FROM grades g
                            JOIN students st ON st.id=g.student_id
                            JOIN subjects su ON su.id=g.subject_id
                            JOIN classes c ON c.id=st.class_id
                            WHERE c.code='$class'
                            GROUP BY st.name, su.name) t
                    GROUP BY t.id) h
            GROUP BY h.osztaly";

    $result = $conn->query($sql);

    return $result;
}

function getThings($conn, $id) {
    $sql = "SELECT su.name as targy, ROUND(AVG(g.grade), 2) as atlag
            FROM grades g
            JOIN students st ON st.id=g.student_id
            JOIN subjects su ON su.id=g.subject_id
            WHERE st.id=$id
            GROUP BY st.name, su.name";

    $result = $conn->query($sql);

    return $result;
}

function getAVG($conn, $id) {
    $sql = "SELECT t.nev, ROUND(AVG(t.atlag), 2) as atlag
            FROM (SELECT st.id as id, st.name as nev, su.name, AVG(g.grade) as atlag
                    FROM grades g
                    JOIN students st ON st.id=g.student_id
                    JOIN subjects su ON su.id=g.subject_id
                WHERE st.id=$id
                GROUP BY st.name, su.name) t
            GROUP BY t.id";
    
    $result = $conn->query($sql);

    return $result;
}

function AVGSubClass($conn, $class) {
    $sql = "SELECT c.code, su.name as targy, ROUND(AVG(g.grade), 2) as atlag
            FROM grades g
            JOIN students st ON st.id=g.student_id
            JOIN subjects su ON su.id=g.subject_id
            JOIN classes c ON c.id=st.class_id
            WHERE c.code='11a'
            GROUP BY c.code, su.name";

    $result = $conn->query($sql);

    return $result;
}

/*Adminhoz szükséges lekérdezések*/

function subjectsSQL($conn) {
    $sql = "SELECT id, name
            FROM subjects
            ORDER BY name";

    $result = $conn->query($sql);

    return $result;
}

function getSubjectById($id) {
    $conn = ConnectDB('schoolbook');

    $sql = "SELECT name
            FROM subjects
            WHERE id=$id";
    
    $result = $conn->query($sql);

    $subject = "";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $subject = $row["name"];
        }
    }
    $conn->close();
    return $subject;
}

function changeSubjectById($id, $newName) {
    $conn = ConnectDB('schoolbook');

    $sql = "UPDATE subjects SET name='$newName' WHERE id=$id";

    $conn->query($sql);

    $conn->close();
}

function deleteSubjectById($id) {
    $conn = ConnectDB('schoolbook');

    $sql = "DELETE FROM subjects WHERE id=$id";

    $conn->query($sql);

    $conn->close();
}



/*Itt van egy mókás szöveeg hihihihihihi*/