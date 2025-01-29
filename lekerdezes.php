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
     "CREATE DATABASE `schoolbook` IF NOT EXISTS
      DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci ;");
}


HTMLBody();
if(isset($_POST["conn-btn"])) {
    $conn = ConnectDB($db);
    CreateDB($conn);
}