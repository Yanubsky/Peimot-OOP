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
    <title>פעימות - הטיפולים שלנו</title>
</head>
<body>
    <?php include '../nav.php'; ?>
    <h1> <?php echo $userName ?> ברוך/ברוכה הבא/ה לדף הטיפולים שלנו </h1>

    <?php include '../js-scripts.php'?>
        <script>
        changeNavbarCurrentPageColor('#therapies');
    </script>

</body>
</html>