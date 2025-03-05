<?php

require_once "lekerdezes.php";
require_once "admin-html.php";

if (!DBExists("schoolbook")) {
    //dropDB("schoolbook");
    MakeDB();
}
htmlBody();