<?php

    include "../classes/User.php";

    //create object
    $user = new User;

    //call the register function
    $user->store($_POST);
    /**
     * $_POST['first_name' => 'John', 'last_name => 'doe', 'username' => 'john.doe', 'password' => 'johndoe1234'];
     */



?>