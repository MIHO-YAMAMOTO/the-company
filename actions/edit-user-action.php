<?php
   
   include "../classes/User.php";

   $user = new User;

   $user->update($_POST, $_FILES);
   /**
    * $_POST = [
    *  'first_name' => 'the new first name',
    *  'last_name' => 'the new last name',
    *  'username' => 'the new username',
    *  ]
    *
    * $_FILES = [
    *  'name' => 'the name of the uploaded image',
    *  'tmp_name' => 'path of the file inside a temporary storage' 
    * ]
    */

?>