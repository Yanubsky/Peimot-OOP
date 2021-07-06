<?php 
    session_set_cookie_params(0);
    session_start();
    include_once 'config.php';
    require_once SITE_ROOT.'/pdo-connection.php';
    require_once SITE_ROOT.'/classes/User.php';
    require_once SITE_ROOT.'/classes/Article.php';
    include_once SITE_ROOT.'/helper-functions.php';
    $action = isset($_GET['action']) ? $_GET['action'] : null; 
    $userName = isset($_SESSION['name']) ? $_SESSION['name'] : null;

    $articleId;
    $imageId;
    
    switch($action){
        case 'signin':
            if(isset($_POST['signin'])){
                User::checkLoginInformation($_POST);
                header("location:http://localhost/myphp/peimot-class/pages/home.php");
            }
        break;
        case 'signout':
            User::logout();
        break;
        case 'register':
            if(isset($_POST['register'])){
                $register = new User($_POST);
                $register->newUser();
            }
        break;
        case 'post-article':
            if(isset($_POST['post-article'])){
                console_log(`inside req-handle.post-article:${$_POST['articleTitle']}`);
                $newArticle = new Article($_POST,$_FILES['articleImages']);
                $newArticle->postArticle();
            }
        break;
        case 'edit-article':
            $artId = $_REQUEST['editArtHidden'];
            Article::editArticle($artId);
        break;
        case 'update-article':
            if(isset($_SESSION['editedArtId'])) {
                $artId = $_SESSION['editedArtId'];
                $topic = $_SESSION['editedArtTopic'];
                $articleTitle = $_SESSION['editedArtTitle'];
                $body = $_SESSION['editedArtcontent'];    
                Article::updateArticle($artId, $body, $topic, $articleTitle);
            }
        break;
        case 'delete-image':
                $imgToDel = $_REQUEST['imgToDel'];
                Article::deleteImages($imgToDel);
        break;
        case 'delete-article':
            $artToDel = $_REQUEST['delete-article'];
            Article::deleteArticle($artToDel);
        break;
    }
?>