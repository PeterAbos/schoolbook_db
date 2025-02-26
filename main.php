<?php

require_once "lekerdezes.php";
require_once "html.php";
require_once "classroom.php";

session_start();

if (!DBExists("schoolbook")) {
    //dropDB("schoolbook");
    MakeDB();
}
HTMLBody();
writeAClass(getClass());