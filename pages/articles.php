<?php
    session_set_cookie_params(0);
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peimot Articles</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/b91b358ead.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
    include '../nav.php';
    require_once '../classes/Article.php';
    include_once '../helper-functions.php';
?>
    <div class="itemsMainDiv">
        <?php 
        $articles = "מאמרים";
            if (isset($_SESSION['email'])) {
                echo '<h1>' . $articles . " במיוחד עבורך " . '</h1>';
                echo "<h3>" . $_SESSION['name'] ."</h3>";   

            } else {
                echo '<h1>' . $articles  . '</h1>';
                echo '<a href="./loginRegister.php"><h4> התחבר </h4></a>';
            }
        ?>
        <div class="articlesTopics">
            <?php 
                require '../myArrays/images-array.php';
                global $myImgsArr;
                for ($i = 0; $i < count($myImgsArr); $i++){ ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> <?php                 
                        echo "<input type='hidden' class='hidden-topic' name='topic' value=$i>";
                        echo "<input type='image' src='$myImgsArr[$i]' name='topic-image' class='topic-image-button'/>";?>
                    </form> <?php
                }
            ?>
        </div>

        <div id="chosenTopic">
        <?php 
            if (isset($_POST['topic'])) {
                switch ($_POST['topic']) {
                    case '0':
                        echo "<div id='topic-name'> <h2> מאמרים בנושא תזונה </h2> </div>";
                        Article::createArticlesArray('nutri');
                        break;
                    case '1':
                        echo "<div id='topic-name'> <h2> מאמרים בנושא נשימה </h2> </div>";
                        Article::createArticlesArray('breath');
                        break;
                    case '2':
                        echo "<div id='topic-name'> <h2> מאמרים בנושא שינה </h2> </div>";
                        Article::createArticlesArray('sleep');
                        break;
                    case '3':
                        echo "<div id='topic-name'> <h2> מאמרים בנושא מודעות </h2> </div>";
                        Article::createArticlesArray('aware');
                        break;
                    case '4':
                        echo "<div id='topic-name'> <h2> מאמרים בנושא תנועה </h2> </div>";
                        Article::createArticlesArray('motion');
                }
            } 
            else 
            {
                console_log("no topic was chosen");
            };

            if (isset($_POST['chosen-article'])){
                $chosenArticle = $_POST['chosen-article'];
                console_log($chosenArticle);
                Article::articleFetch($chosenArticle); 
            };

        ?>  
        </div>
    </div>
    <?php include '../js-scripts.php'?>
        <script>
        changeNavbarCurrentPageColor('#articles');
    </script>
</body>

</html>

