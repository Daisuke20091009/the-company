<?php

include "../classes/User.php"; //include the user class

// 1. create a new user
$user = new User;

// 2. call the update method 
// pass both $_POST and $_FILES to the update method
$user->update($_POST, $_FILES);

?>