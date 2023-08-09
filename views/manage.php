<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Folio | Manage</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>

<body>
    <div class="manageContainer">
        <div class="optionContainer">
            <button class="option">Manage Data</button>
            <button class="option">Add Template</button>
            <button class="option">Go Back</button>
            <button class="option">Logout</button>
        </div>
        <div class="rightContainer">
            <form action="" method="post" id="dataForm">
                <div class="dataFormContainer">
                    <h2>Personal Details</h2>
                    <input type="text" placeholder="name" name="name">
                    <textarea name="about_me" cols="60" rows="15" placeholder="Enter about yourself"></textarea>
                    <button class="next" onclick=" document.getElementById('dataForm').style.transform = 'translateX(-80vw)' ">
                        NEXT</button>
                </div>
                <div class="dataFormContainer">
                    <h2>Skills</h2>
                    <input type="text" placeholder="name" name="name">
                    <textarea name="about_me" cols="25" rows="5" placeholder="Enter about yourself"></textarea>
                    <button class="next" onclick=" document.getElementById('dataForm').style.transform = 'translateX(-80vw)' ">
                        NEXT</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../static/main.js"></script>
</body>

</html>