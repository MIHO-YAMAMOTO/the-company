<?php
require_once "Database.php";

   //This will serve as the brain (the logic) of the 
   //application will save here [C-create, R-read, U-update, D-delete]
   class User extends Database{
         public function store($request){
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $username = $request['username'];
            $password = $request['password'];

            /**
             * create the query string 
             */ 
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(`first_name`, `last_name`, `username`, `password`) VALUES('$first_name', '$last_name', '$username', '$password')";

            /**
             * Execute the query string
             */ 
            if($this->conn->query($sql)){
                header('location:  ../views');
                exit;
            }else{
                die('Error in creating the user: ' . $this->conn->error);
            }
         }

         public function login($request){
            //received the username and password from the form
            $username = $request['username'];
            $password = $request['password'];

            #Query string
            $sql = "SELECT * FROM users WHERE username = '$username'";

            $result = $this->conn->query($sql);

            #Check if the username exists
            if($result->num_rows == 1){ //built-in PHP: true(1) or false(0)?
                #Check if the password is correct
                $user = $result->fetch_assoc(); //built-in PHP
                /**
                 * $user = [
                 *     'id' => 2,
                 *     'username' => 'john.smith',
                 *     'password' => '123fs0sds@@d48*s%865%'
                 * ]
                 */
                if(password_verify($password, $user['password'])){
                    #Create session variables for future use...
                    session_start();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['first_name'] . " " . $user['last_name'];
                    
                    header('location: ../views/dashboard.php');
                    exit;
                }else{
                    die("Password is incorrect.");
                }
            }else{
                die("Username does not exist.");
            }
         }

         public function logout(){
            session_start();
            session_unset();
            session_destroy();

            header("location: ../views/"); //login page
            exit;
         }

         /**
          * Function to retrieve all users from the users table
          */
          public function getAllUsers(){
            $sql = "SELECT id, first_name, last_name, username, photo FROM users";
            if($result = $this->conn->query($sql)){
                return $result;
            }else{
                die("Error in retrieving all users: " . $this->conn->error);
            }
          }

          /**
           * Get the information of the current logged-in user
           */
          public function getUser($id){
            $sql = "SELECT * FROM users WHERE id = $id";
            if($result = $this->conn->query($sql)){
                return $result->fetch_assoc();
            }else{
                die("Error in retrieving the user: " . $this->conn->error);
            } 
          }

          /**
           * Actual function that perform the updating of record
           */
          public function update($request, $files){
            session_start();
            $id = $_SESSION['id']; //id of the current logged-in user
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $username = $request['username'];

            # Uploaded image
            $photo = $files['photo']['name'];
            $tmp_photo = $files['photo']['tmp_name']; //temporary name in the temporary storage location

            # SQL query string
            $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id = $id";

            if($this->conn->query($sql)){
                $_SESSION['username'] = $username;
                $_SESSION['full_name'] = "$first_name $last_name";

                # if there is an uploaded photo, save it to the DB and save the actual image to the '/assets/images' folder
                if($photo){
                    $sql = "UPDATE users SET photo = '$photo' WHERE id =  $id";
                    $destination = "../assets/images/$photo";

                    /**
                     * Save the image name to the DB
                     */
                    if($this->conn->query($sql)){
                        # Save the actual file to the images folder
                        if(move_uploaded_file($tmp_photo, $destination)){
                            header('location: ../views/dashboard.php');
                            exit;
                        }else{
                            die("Error in moving the photo.");
                        }
                    }else{
                        die("Error in uploading the photo:" . $this->conn->error);
                    }
                }
                header('location: ../views/dashboard.php');
                exit;
            }else{
                die("Error in updating the user: " . $this->conn->error);
            }
          }

          public function delete(){
            session_start();
            $id = $_SESSION['id']; //id of the logged-in user
            $sql = "DELETE FROM users WHERE id = $id";

            if($this->conn->query($sql)){
                $this->logout();
            }else{
                die("Error in deleting the account: " . $this->conn->error);
            }
          }
   }

?>