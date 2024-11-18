<?php

include "../classes/User.php";

// step1: create a new user object
$user = new User;

// step2: call the ligout method
// This will log the user out by ending their session
$user->logout();

?>