<?php
$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM `folio_user` WHERE `username` = '$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if($num == 1){
        while($row = mysqli_fetch_assoc($result)){
            if(password_verify($password, $row['password']))  {
                $login = true;
                session_start();
                $_SESSION['loggedIn'] = true; 
                $_SESSION['username'] = $username; 
                header("location: ../views/home.php");
            }else{
                $showError = "Invalid Credentials";
            }        
        }
    }
    else{
        $showError = "Invalid Credentials";
    }

}
