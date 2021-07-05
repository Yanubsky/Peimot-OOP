<?php
    session_set_cookie_params(0);
    session_start();
    if(isset($_SESSION['email'])){
        header("location:http://localhost/myphp/peimot-class/pages/home.php");
    }
?>

<!DOCTYPE html>
<html lang="heb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/b91b358ead.js" crossorigin="anonymous"></script>
    <title>התחברות</title>
</head>
<body>
    <?php include '../nav.php'?>
    <div class="forms-main-div">
        <div class="oneFormDiv">
            <form id="loginForm" method="POST" action="../req-handle.php?action=signin">
                <fieldset>
                    <legend>התחבר</legend>
                    <input type="email" name="email" id="loginEmail" onfocus="this.value=''" value='דוא"ל'> <label for="loginEmail">כתובת דוא"ל</label>
                    <br>
                    <div class="passInputDiv">
                        <input type="password" name="pass" class="toggleLoginPass" id="loginPass" minlength="4" maxlength="16" required size="16" onfocus="this.value=''" value="***********"> 
                        <i class="far fa-eye" id="toggleLoginPass" style="opacity: 0.7;" onclick="togggleVisPass(this.id)" ></i><label for="loginPass" class="passLable">סיסמא</label> 
                    </div>
                    <br>
                    <button name="signin" id="singinBtn" value="signin">התחבר</button>
                    <br><br>
                </fieldset>
            </form>
        </div>

        <div class="oneFormDiv">
            <form id="registerForm" method="POST" action="../req-handle.php?action=register">
                <fieldset>
                    <legend> הרשמה זריזה </legend>
                    <input type="text" name="name" id="registerName" onfocus="this.value=''" value='שם משתמש'> <label for="registerName">שם משתמש</label>
                    <br>
                     <input type="email" name="email" id="registerEmail" onfocus="this.value=''" value='דוא"ל'><label for="registerEmail">כתובת דוא"ל</label>
                    <br>
                    <div class="passInputDiv">
                        <input type="password" name="pass" class="toggleRegPass" id="regPass" minlength="4" maxlength="16" required size="16" onfocus="this.value=''" value="***********"> 
                        <i class="far fa-eye" id="toggleRegPass" style="opacity: 0.7;" onclick="togggleVisPass(this.id)"></i><label for="regPass" class="passLable">סיסמא</label>
                    </div>
                    <br>
                    <div class="passInputDiv">
                        <input type="password" name="confirmPass" class="toggleConfirmPass" id="confirmPass" minlength="4" maxlength="16" required size="16" onfocus="this.value=''" value="***********">
                        <i class="far fa-eye" id="toggleConfirmPass" style="opacity: 0.7;" onclick="togggleVisPass(this.id)"></i><label for="confirmPass" class="passLable">אישור סיסמא</label>
                    </div>
                    <br>
                    <button name="register" value="REGISTER">הרשמה</button>
                    <br><br>
                </fieldset>
            </form>
        </div>
    </div>

    <?php include '../js-scripts.php' ?>
    <!-- <script>
        changeNavbarCurrentPageColor('#login');
    </script>
 -->
</body>

</html>