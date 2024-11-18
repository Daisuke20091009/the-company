<?php

require_once "Database.php";

class User extends Database{

    public function store($request){
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $username  = $request['username'];
        $password = $request['password'];

        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(`first_name`, `last_name`, `username`, `password`)
                VALUES('$first_name', '$last_name', '$username', '$password')";

        if($this->conn->query($sql)){
        header('location: ../views');
        exit;
        }else{
        die('Error creating the user:'.$this->conn->error);
        }
    }


    public function login($request){

        $username = $request['username'];
        $password = $request['password'];

        $sql = "SELECT * FROM Users WHERE username = '$username'";

        $result = $this->conn->query($sql);

        if($result->num_rows == 1){

            $users = $result->fetch_assoc();

            if(password_verify($password, $users['password'])){

                session_start();

                $_SESSION['id']  =  $users['id'];
                $_SESSION['username']  =  $users['username'];

                header('location:../views/dashboard.php');
                exit;
            }else{
                die('password is incorrect');
            }
            }else{
                die('Username not found');
        }
    }

    public function logout(){

        // 1 start the session
        session_start();

        // 2 Remove all session
        session_unset();

        // 3 destroy the session
        session_destroy();

        // 4 Redirect the user to the login
        header('location: ../views');
        exit; //stop
    }

    public function getAllUsers(){

        // 1.Write the sql query to select certain columns from the user
        $sql = "SELECT id, first_name, last_name, username, photo FROM users";
        // this will get ......

        // 2 run the query on the database
        if($result = $this->conn->query($sql)){
            return $result;
        }else{

            die('Error retrieving all users:' . $this->conn->error);
        }

    }

    public function getUser($id){

        $sql = "SELECT * FROM users WHERE id = $id";
        
        
        if($result = $this->conn->query($sql)){
            return $result->fetch_assoc();
        }else{
            die('Error retrieving the user:' . $this->conn->error);
        }
    }

    public function update($request, $files){

        session_start();

        $id = $_SESSION['id'];

        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $username = $request['username'];
        $photo = $files['photo']['name'];
        $tmp_photo = $files['photo']['tmp_name'];

        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id = $id";

        if($this->conn->query($sql)){

            $_SESSION['username'] = $username;
            $_SESSION['full_name'] = "$first_name $last_name";

            if($photo){

                $sql = "UPDATE users SET photo = '$photo' WHERE id = $id";

                $destination = "../assets/images/$photo";
                
                if($this->conn->query($sql)){

                    if(move_uploaded_file($tmp_photo, $destination)){

                        header('location: ../views/dashboard.php');
                        exit;
                    }else {
                        die('Error moving the photo.');
                    }
                } else {

                    die('Error uploading photo:' . $this->conn->error);
                }
            }
        

        header('location: ../views/dashboard.php');
        exit;

        }else{
            die('Error updating the user:' .$this->conn->error);
        }


    }

    public function delete(){
        session_start();

        $id = $_SESSION['id'];

        $sql = "DELETE FROM users WHERE id = $id";

        if($this->conn->query($sql)){

            session_unset();
            session_destroy();
            header('location: ../views/index.php');
            exit;
        }else{
            die('Error deleting user: '. $this->conn->error);
        }
    }

}

?>

