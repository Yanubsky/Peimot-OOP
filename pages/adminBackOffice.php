<?php
    session_set_cookie_params(0);
    session_start();
    $userName;
    if(isset($_SESSION['email'])){
        $userName = $_SESSION['name'];
    }
    else {
        $userName= '';
        header("location:http://localhost/myphp/peimot-class/pages/loginRegister.php");
        die();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/b91b358ead.js" crossorigin="anonymous"></script>
    <title> עמדת ניהול </title>
</head>
<body class="form-body">
    <?php 
        include '../nav.php';
        // vars containing subjects for management
        $about = " קצת עלי ";
        $users = " משתמשים";
        $therapies = " טיפולים ";
        $updateArticles = " עדכון מאמרים ";
        $deleteArticles = " מחיקת מאמרים ";
        $articles = " פרסום מאמר ";
        $update = " עדכון פרטים ";
    ?>
    <div id="adminHeader">
        <h2>מנהל יקר</h2><br>
        <h2>דף זה משמש לעריכת המידע באתר, אנא השתמש בו בזהירות רבה</h2> <hr><br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
            <button id="about" class="adminChoice" type="submit" name="choise" value="about"><?php echo $about?></button>
            <button id="users" class="adminChoice" type="submit" name="choise" value="users"><?php echo $users?></button>       
            <button id="therapies" class="adminChoice" type="submit" name="choise" value="therapies"><?php echo $therapies?></button>
            <button id="articlesUpdate" class="adminChoice" type="submit" name="choise" value="articlesUpdate"><?php echo $updateArticles?></button>
            <button id="deleteArticles" class="adminChoice" type="submit" name="choise" value="deleteArticles"><?php echo $deleteArticles?></button>
            <button id="articles" class="adminChoice" type="submit" name="choise" value="articles"><?php echo $articles?></button>
            <button id="update" class="adminChoice" type="submit" name="choise" value="update"><?php echo $update?></button>
        </form>
    </div>

    <div id="admin-choise">
        <?php 
            if(isset($_POST['choise'])){
                include_once '../js-scripts.php';
                switch ($_POST["choise"]) {
                    case 'update':
                        include '../admin-components/update-details-admin.php';
                        echo '<script> changeAdminCurrentComponentColor(`#update`) </script>';
                    break;
                    case 'articles':
                        include '../admin-components/post-articles.php';
                        echo '<script> changeAdminCurrentComponentColor(`#articles`) </script>';
                    break;
                    case 'articlesUpdate':
                        include '../admin-components/editArticle.php';
                        include_once SITE_ROOT.'/classes/Article.php';
                        echo '<script> changeAdminCurrentComponentColor(`#articlesUpdate`) </script>';
                    break;
                    case 'deleteArticles':
                        include '../admin-components/delete-articles.php';
                        include_once SITE_ROOT.'/classes/Article.php';
                        echo '<script> changeAdminCurrentComponentColor(`#deleteArticles`) </script>';
                    break;
                    case 'therapies':
                        include '../admin-components/update-therapies.php';
                        echo '<script> changeAdminCurrentComponentColor(`#therapies`) </script>';
                    break;
                    case 'users':
                        include '../admin-components/update-users.php';
                        echo '<script> changeAdminCurrentComponentCoolr(`#users`) </script>';
                    break;
                    case 'about':
                        include '../admin-components/update-about.php';
                        echo '<script> changeAdminCurrentComponentColor(`#about`) </script>';
                    break;
                }       
            }
        ?>

    </div>

<?php include_once '../js-scripts.php';?>
<script>
    changeNavbarCurrentPageColor('#admin');
</script>

</body>
</html>


