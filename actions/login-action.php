<?php

include "../classes/User.php";

/**
 * Create object
 */
$user = new User;

/**
 * Call the login function
 */
$user->login($_POST);
/**
* $_POST['username' => 'john.smith', 'password' => '123fs0sds@@d48*s%865%'];
*/


?>