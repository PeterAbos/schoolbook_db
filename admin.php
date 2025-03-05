<?php

require_once "lekerdezes.php";
require_once "admin-html.php";
require_once "admin-classroom.php";

if (!DBExists("schoolbook")) {
    //dropDB("schoolbook");
    MakeDB();
}
htmlBody();