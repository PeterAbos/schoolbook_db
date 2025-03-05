<?php

if (!DBExists("schoolbook")) {
    //dropDB("schoolbook");
    MakeDB();
}