/*schoolbook adatbázis létrehozása*/
CREATE DATABASE `schoolbook` IF NOT EXISTS
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci ;

/*Táblák létrehozása*/
/*Students tábla*/
CREATE TABLE `students` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	gender INT,
	class_id INT
)

/*Classes tábla*/
CREATE TABLE `classes` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	code VARCHAR(3),
	year YEAR
)

/*Subjects tábla*/
CREATE TABLE `subjects` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(20) NOT NULL
)

/*Grades tábla*/
CREATE TABLE `grades` (
	id INT AUTO_INCREMENT PRIMARY KEY,
	student_id INT,
	subject_id INT,
	grade INT,
	date DATE
)

INSERT INTO subjects (id, name)
VALUES (0, "név");