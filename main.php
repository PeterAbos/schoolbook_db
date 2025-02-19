<?php

require_once "lekerdezes.php";
require_once "html.php";
require_once "classroom.php";



if (DBExists("schoolbook")) {
    dropDB("schoolbook");
}
MakeDB();
$conn = ConnectDB("schoolbook");
echo "Létezik";