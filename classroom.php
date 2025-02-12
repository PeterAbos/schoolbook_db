<?php

require_once "classroom-data.php";

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
                    $datum = date('Y-m-d');
                    InsertToGrades($conn, $idCounter, $subject, $randomGrade, $datum);
                }
            }

            $idCounter++;
        }
    }
}