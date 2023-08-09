<?php
$login = false;
$showError = false;
if ((isset($_SESSION['loggedIn'])) && $_SESSION['loggedIn'] == true) {
    $login = true;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../app/database.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $sql = "SELECT * FROM `folio_user` WHERE `username` = '$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $login = true;
                session_start();
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;
            } else {
                $showError = "Invalid Credentials";
            }
        }
    } else if ($num == 0 && ($password === $cpassword)) {
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
            $login = true;
        }
    } else {
        $showError = "Invalid Credentials";
    }
}

function performLogout(bool $login)
{
    if ($login) {
        $login = false;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="../static/styles.css" />

</head>

<body>
    <nav id="nav">
        <h2>FOLIO<b>.</b></h2>
        <ul class="navbar">
            <li><a href="#" class="active">Home</a></li>
            <li><a href="#templates">Templates</a></li>
        </ul>
        <div class="buttonSpace">
            <?php
            if (!$login) {
                echo '
            <button class="login" id="loginButton" onclick = "displayForm()">Login in</button>';
            } else {
                echo '
            <button class="login" id="manageButton" onclick="performLogout($login)">Log out</button>';
            }
            ?>
            <img src="../static/Image/darkMode.png" alt="" srcset="" id="mode">
        </div>
    </nav>
    <?php
    if ($showError != false) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>' . $showError . ' 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    } else if ($login) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in successful.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <div class="container" id="formContainer">
        <div class="form-container sign-up-container">
            <button class="exitButton" onclick="document.getElementById('formContainer').style.display = 'none'">X</button>
            <form action="../public/index.php" method="post">
                <h1 class="greenHead">Create Account</h1>
                <input type="email" name="username" placeholder="username@gmail.com" maxlength="100" />
                <input type="password" name="password" minlength="8" placeholder="password" />
                <input type="password" name="cpassword" minlength="8" placeholder="confirm your password" />
                <button type="submit">Sign Up</button>
            </form>
        </div>
        <div class="form-container log-in-container">
            <button class="exitButton" onclick="document.getElementById('formContainer').style.display = 'none'">X</button>
            <form action="../public/index.php" method="post">
                <h1 class="greenHead">Log in</h1>
                <input type="email" placeholder="username@gmail.com" name="username" />
                <input type="password" placeholder="Password" name="password" />
                <!-- <a href="#">Forgot your password?</a> -->
                <button type="submit">Log In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="hInfo">Welcome Back!</h1>
                    <p class="formInfo">Already have an account? Log In</p>
                    <button class="ghost" id="logIn">Log In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class="hInfo">Hello, There!</h1>
                    <p class="formInfo">Don't have an account? Sign Up Free</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <section id="hero">
        <div id="heroLeft">
            <h1>
                FOLIO<b>.</b>
            </h1>
            <h2>
                The site you want -
                without dev time.
            </h2>
        </div>
        <div id="heroRight">
            <h3>
                Your website should be your marketing asset not an engineering asset.
            </h3>
            <div class="buildButton">
                <a href="#templates">Start Building</a>
            </div>
        </div>
    </section>
    <h2 class="cardSectionHeader hidden">
        Welcome to the world's most popular portfolio builder.
    </h2>
    <section id="cardSection">
        <div class="cardContainer hidden">
            <div class="cardImg cardContent">
                <img src="../static/Image/responsive.png" alt="" srcset="">
            </div>
            <div class="cardInfo cardContent">
                <b>Responsive</b>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia quae consectetur minima nulla sapiente perferendis voluptas nihil ut voluptatibus quidem?
            </div>
        </div>
        <div class="cardContainer hidden">
            <div class="cardImg cardContent">
                <img src="../static/Image/easy.png" alt="" srcset="">
            </div>
            <div class="cardInfo cardContent">
                <b>Easy to use</b>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia quae consectetur minima nulla sapiente perferendis voluptas nihil ut voluptatibus quidem?
            </div>
        </div>
        <div class="cardContainer hidden">
            <div class="cardImg cardContent">
                <img src="../static/Image/mail.png" alt="" srcset="">
            </div>
            <div class="cardInfo cardContent">
                <b>Easy to obtain</b>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia quae consectetur minima nulla sapiente perferendis voluptas nihil ut voluptatibus quidem?
            </div>
        </div>
    </section>
    <div class="cardSectionFooter">
        <h2 class="hidden">
            Join the
            <br>
            community
        </h2>
        <div class="hidden">
            Add or Get the most professional portfolio.
            <a href="../views/login.html">Join now</a>
        </div>
    </div>
    <section id="templates">
        <h2>
            Stand out with stylish
            themes and patterns
        </h2>
        <h3>Templates
            <b>...</b>
        </h3>
        <div class="templateContainer">
            <?php foreach ($templates as $i => $template) : ?>
                <div class="templateCard">
                    <div class="templatePreview">
                        <img src="<?php echo $preview[$i] ?>" alt="">
                        <div class="templateName">
                            <?php echo $names[$i] ?>
                        </div>
                    </div>
                    <div class="templateCardFooter">
                        <a href="<?php echo $template ?>" target="_blank">Preview</a>
                        <?php if ($login):?>
                            <a href="<?php echo $forms[$i] ?>" target="_blank">Get</a>;
                            
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </section>
    <script src="../static/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js" integrity="sha512-f8mwTB+Bs8a5c46DEm7HQLcJuHMBaH/UFlcgyetMqqkvTcYg4g5VXsYR71b3qC82lZytjNYvBj2pf0VekA9/FQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js" integrity="sha512-A64Nik4Ql7/W/PJk2RNOmVyC/Chobn5TY08CiKEX50Sdw+33WTOpPJ/63bfWPl0hxiRv1trPs5prKO8CpA7VNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@0.2.28/bundled/lenis.js"></script>
</body>

</html>