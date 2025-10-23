<?php
   session_start();

   require "../classes/User.php";    //link the User.php

   $user_obj = new User;             //create / instantiate the object

   $all_users = $user_obj->getAllUsers(); //call the function using the object in line 6
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- CDN CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <!-- CDN Font Awsome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!-- css link -->
      <link rel="stylesheet" href="../assets/css/style.css">
    
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px;">
          <div class="container">
            <a href="dashborad.php" class="navbar-brand">
                <h1 class="h3">The Company</h1>
            </a>
            <div class="navbar-nav">
                <span class="navbar-text"><?= $_SESSION['full_name'] ?></span>
                <form action="../actions/logout-action.php" method="post" class="d-flex ms-2">
                      <button type="submit" class="text-danger bg-transparent border-0">Logout</button>
                </form>
            </div>
          </div>
    </nav>

    <main class="row justify-content-center gx-0">
        <div class="col-6">
            <h2 class="text-center">User List</h2>

            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                       while($user = $all_users->fetch_assoc()){
                    ?>

                       <tr>
                        <td>
                            <?php
                                if($user['photo']){
                            ?>
                                <img src="../assets/images/<?= $user['photo'] ?>" alt="<?= $user['photo'] ?>" class="d-block mx-auto dashboard-photo">
                            <?php
                                }else{
                            ?>
                                <i class="fa-solid fa-user text-secondary d-block text-center dashboard-icon"></i>
                            <?php            
                                }
                            ?>                               
                        </td>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['first_name'] ?></td>
                        <td><?= $user['last_name'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td>
                            <?php
                               if($_SESSION['id'] == $user['id']){
                            ?>
                               <a href="edit-user.php" class="btn btn-outline-warning" title="Edit">
                                  <i class="fa-regular fa-pen-to-square"></i>
                               </a>
                               <a href="delete-user.php" class="btn btn-outline-danger" title="Delete">
                                  <i class="fa-regular fa-trash-can"></i>
                               </a>
                            <?php
                            }
                            ?>
                        </td>
                       </tr>
                       <?php        
                         }
                         ?>
                </tbody>
            </table>
        </div>
    </main>
   





    
    

    <!-- CDN Javasvript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">        
    </script>    
</body>
</html>