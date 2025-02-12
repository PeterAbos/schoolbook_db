<?php

require_once "lekerdezes.php";
require_once "html.php";
require_once "classroom.php";



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