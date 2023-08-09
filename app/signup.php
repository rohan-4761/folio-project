<?php
$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $existSql = "SELECT * FROM `folio_user` WHERE `username` = '$username'";
    $existResult = mysqli_query($conn, $existSql);
    $usernameExists = mysqli_num_rows($existResult);
    if (($password === $cpassword) && $usernameExists == 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `folio_user` (`username`, `password`) VALUES ('$username', '$hash')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $showAlert = false;
        } else {
            $showAlert = true;
            session_start();
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $username;
            header("location: ../public/index.php");
            
        }
    } else if ($password !== $cpassword) {
        $showError = "Passwords did not match.";
    } else {
        $showError = "Username already exists";
    }
}
