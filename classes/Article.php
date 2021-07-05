<?php 
include_once '../config.php';
// include_once SITE_ROOT.'/helper-functions.php';
require_once SITE_ROOT.'/pdo-connection.php';
class Article{
// properties related to the articles table in the db
    private ?string $topic;
    private ?string $articleTitle;
    private ?string $recievedContent;
    private ?string $content;
// properties related to the images table in the db
    private ?array $imagesArray;
    private ?int $countFiles;
    private ?string $imageName;
    private ?string $tmpName;
    private ?int $articleId;
    private ?string $imageType;
    private ?int $imageSize;

    public function __construct ( $articleData= array(), $images= array() ) {
        if (isset($articleData['topic'])) $this->topic = $articleData['topic'];
        if (isset($articleData['articleTitle'])) $this->articleTitle = $articleData['articleTitle'];
        if (isset($articleData['content'])) $this->recievedContent = $articleData['content']; // Here the only input comes from the admin but for forum & other kind of multi-users sites recieving input text from anonymous users we should (TODO:) use "HTML Purifier" - a library ment for purifing text inputs - http://htmlpurifier.org/
        
        if (isset($images)) {
            $this->countFiles = count($images['name']);
            $this->imagesArray = $images;
        };

        // try 
        // {
        //     $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        //     $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // } 
        // catch (PDOException $e) {
        //     echo "Error : " . $e->getMessage() . "<br/>";
        //     die();
        // }
          
    }

// ============== creating a new article in the database ============== //
    public function postArticle(){
        global $con;
        // reshaping the article - replacing predetermined symbols with tags
        $textMap = array("(--)", "(---)", "(-)", "(..)", "(***)", "(****)", "|-|", "|--|");
        $textValue = array("<h2>", "</h2>", "<br>", "<br><br>", "<strong>", "</strong>", "<div class=one-image><img src='", "' width='500' height='600'> </div>");
        $this->content = str_replace($textMap, $textValue, $this->recievedContent);

        $updateArticles= $con->prepare(
            "CREATE TABLE IF NOT EXISTS articles(
                id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                topic varchar(10) NOT NULL,
                articleTitle varchar(60) NOT NULL,
                content text NOT NULL,
                postDate date NOT NULL,
                PRIMARY KEY (id),
                UNIQUE KEY (articleTitle)
            );"
        );
        $updateArticles->execute();
        $articlesQuery = "INSERT INTO `articles`
        (`topic`, `articleTitle`, `content`, `postDate`)
        VALUES
        (:topic, :articleTitle, :content, NOW())";

        $query1 = $con->prepare($articlesQuery);
            $query1->bindParam(':topic', $this->topic);
            $query1->bindParam(':articleTitle', $this->articleTitle);
            $query1->bindParam(':content', $this->content);
        $query1->execute();
        $lastInsertId = $con->lastInsertId();
        //--------- images handle ---------//
        if ($lastInsertId > 0 && $this->countFiles > 0 ) {
            console_log('inside postArticle func -> image handle');
            $phpFileUploadErrors = array(
                0 => 'There is no error, the file uploaded with success',
                1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                3 => 'The uploaded file was only partially uploaded',
                4 => 'No file was uploaded',
                6 => 'Missing a temporary folder',
                7 => 'Failed to write file to disk.',
                8 => 'A PHP extension stopped the file upload.',
            );
    
            $filesArray = reArrayFiles($this->imagesArray, $this->countFiles);
            for ($i=0;$i<count($filesArray);$i++) {
                if ($filesArray[$i]['error']) {
                    ?> <div class="alert alert-danger">
                            <?php echo $filesArray[$i]['name']. '-' . $phpFileUploadErrors[$filesArray[$i]['error']]; ?> </div><?php
                } 
                else 
                {
                    // getting the last added articleId
                    $select= $con->prepare("SELECT * FROM articles WHERE articleTitle = '$this->articleTitle'");
                    $select->setFetchMode(PDO::FETCH_ASSOC);
                    $select->execute();
                    $data=$select->fetch();

                    //saving the image on the server
                    $this->imageName = $filesArray[$i]['name'];
                    $this->tmpName = $filesArray[$i]['tmp_name'];
                    $dirTale = $this->articleTitle . '_'; // this part is ment to make a hebrew dir-name .
                    $destination = 'D:/xampp/htdocs/myphp/peimot-class/uploaded/' . $dirTale;
                    if (!is_dir($destination)){
                        mkdir($destination);
                    };
                    move_uploaded_file($this->tmpName, "$destination/$this->imageName");
                    // populating vars for db query
                    $this->articleId = $data['id'];
                    $imageUrl = $destination . "/" . $this->imageName;
                    $this->imageSize = $filesArray[$i]['size'];
                    $this->imageType = $filesArray[$i]['type'];

                    $updateImgs = $con->prepare(
                        "CREATE TABLE IF NOT EXISTS images(
                            articleId INT (10) UNSIGNED NOT NULL,
                            imageId INT (10) UNSIGNED NOT NULL AUTO_INCREMENT,
                            img varchar (4000) NOT NULL,
                            imageName varchar (55) NOT NULL,
                            size varchar (55) NOT NULL,
                            imageType varchar (55) NOT NULL,
                            -- themeImage boolean,
                            PRIMARY KEY (imageId),
                            FOREIGN KEY (articleId) REFERENCES articles(id)                
                        );"
                    );
                    $updateImgs->execute();
                    $imgsQuery = "INSERT INTO `images`
                    (`articleId`,`imageName`,`img`,`size`,`imageType`)
                    VALUES
                    (:articleId,:imageName,:img,:size,:imageType)";
                    $query3 = $con->prepare($imgsQuery);
                        $query3->bindParam(':articleId', $this->articleId);
                        $query3->bindParam(':imageName', $this->imageName);
                        $query3->bindParam(':img', $imageUrl);
                        $query3->bindParam(':size', $this->imageSize);
                        $query3->bindParam(':imageType', $this->imageType);
                    $query3->execute();
                    $lastInsertId_images = $con->lastInsertId();
                    if($lastInsertId_images > 0 && $lastInsertId_images !== $lastInsertId) {
                        echo `<h1> המאמר על בהצלחה</h1>`;
                        header("location:/myphp/peimot-class/pages/articles.php");
                    } 
                    else 
                    {   // TODO: check if the article really doesn't get uploaded or maybe it does only without the images...
                        echo "<h2>המאמר לא התווסף לאתר, **בעיה בהוספת תמונות** אנא נסה שוב או פנה לתמיכה אם התקלה נשנית</h2>";
                        // i want the next code line will run only after 5 sec
                        // sleep(5);
                        // header("location:http://localhost/myphp/peimot-class/pages/adminBackOffice.php");
                    }
                }
            }
        }
        else
        {
            echo `<h1> המאמר על בהצלחה - לא נוספו תמונות, ניתן לעדכן את המאמר ולהוסיף תמונות בהמשך</h1>`;
            // header("location:/myphp/peimot/pages/articles.php");
        }
    }

// creating an array from the articles in the db, arrange it by topics (nutri,breath,sleep,aware,motion), and 
    public static function createArticlesArray($desiredTopic){
        global $con;
        $selectArticleTopic = $con->prepare("SELECT id, topic, articleTitle, img FROM articles a JOIN images i 
                                            ON (a.id = i.articleId) WHERE a.topic = '".$desiredTopic."' GROUP BY a.id");
        $selectArticleTopic->setFetchMode(PDO::FETCH_ASSOC);
        $selectArticleTopic->execute();
        $chosenTopicArticlesArray = $selectArticleTopic->fetchAll();
    
        //     echo "createArticlesArray prints:";
        //    preArr($nutriArticles);     // checking which kind of an array was fetched
    
        foreach($chosenTopicArticlesArray as $key => $val) { 
            // echo $key . "<br> ******* <br>";

            $artImg= $val['img'];
            $finalImg = stristr($artImg , "/myphp"); 
            $articleId = $val['id'];

            echo "<div class='article-details-and-image'>";
            echo "<br>" . " <h4>"  . $val['articleTitle'] . "</h4>" . "<br>";
            echo "<div class='chosen-topic-articles'>"; 
        ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <?php                 
            echo "<input type='hidden' class='hidden-article' name='chosen-article' value=$articleId>";
            echo "<input type='image' src='$finalImg' style='height: 300px; width:300px; padding: 20px' name='article-image' class='article-image-button'/>"
        ?>
            </form>
        <?php
            echo "</div> </div>";
        }
    }

// =========================== getting an article from the db ================================== //
    public static function articleFetch($chosenArticleId){ 
        global $con;
    
        $selectArticle = $con->prepare("SELECT content FROM articles a WHERE a.id = '".$chosenArticleId."'");
        $selectArticle-> setFetchMode(PDO::FETCH_ASSOC);
        $selectArticle-> execute();
        $contentToScan = $selectArticle->fetch();
    
        $selectImages = $con->prepare("SELECT * FROM images i WHERE i.articleId = '".$chosenArticleId."'");
        $selectImages->setFetchMode(PDO::FETCH_ASSOC);
        $selectImages->execute();
        $imagesArray = $selectImages->fetchAll();
    
        $positionsArray = array();
        $urlsArray = array();
        foreach($imagesArray as $curr){
            $positionInText = $curr['imageName'];
            array_push($positionsArray,$positionInText);
    
            $imageUrl = $curr['img'];
            $finalImg = stristr($imageUrl , "/myphp"); 
            array_push($urlsArray, $finalImg);
        }
        $txtToPublish = str_replace($positionsArray, $urlsArray, $contentToScan);
        $printableArticle = $txtToPublish['content'];
        echo "<div id='being-read' dir='rtl'>" . "<br>". $printableArticle . "<br>";
        echo "</div>";
    }

// ---------------getting all articles from db----------------------//
    public static function getList(){
        global $con;
        $getArticlesListQuery = 
            'SELECT id, topic, articleTitle, postDate, img FROM articles AS a 
            JOIN images AS i ON (a.id = i.articleId) 
            GROUP BY a.id 
            ORDER BY postDate DESC';

        $query4 = $con->prepare($getArticlesListQuery);
        $query4->execute();
        $listOfArticles = array();
        while ($eachRow = $query4->fetch()){
            array_push($listOfArticles, $eachRow);
        };
        $numOfFoundArticle = count($listOfArticles);
        include_once '../helper-functions.php';
        for($i = 0; $i<$numOfFoundArticle; $i++ ){
            $id = $listOfArticles[$i]['id'];
            $topic = $listOfArticles[$i]['topic'];
            $name = $listOfArticles[$i]['articleTitle'];
            $date = $listOfArticles[$i]['postDate'];
            $imageUrl = $listOfArticles[$i]['img'];
            $image = stristr($imageUrl , "/myphp"); 

            // console_log($id . '-' . $topic . '-' . $name . '-' . $date . '-' . $image);
            echo '<form class="edit-article-form" method="GET" action="../req-handle.php?action=edit-article">
                    <tr>
                        <td> <input type="checkbox" name="adminArticlesTable" id="checkbox#' . $id . '" class="articleTableCheckboxes"> </td>
                        <td> <a role="button" href="../req-handle.php?action=edit-article" name="articleToEdit" class="editBtn"> עריכה </buttonbtton> <input type="hidden" name="articleToEdit" id="articleToEdit" value="'.$id.'" class="artToEdit"> </td>
                        <td> <a role="button" href="../req-handle.php?action=delete-article" class="deleteArticleBtn">מחיקה</a> <input type="hidden" name="articleToDel" id="articleToDel" value="'.$id.'" class="artToDel"> </td>
                        <th scope="row">' . $id . '</th>
                        <td>' . $topic . '</td>
                        <td>' . $name . '</td>
                        <td>' . $date . '</td>
                        <td><img src="' . $image . '" alt="' . $name . '" style="width:100px; padding: 20px" class="articleTableImages"></td>
                    </tr>
                </form>';
        }
    }

    public static function editArticle($artId){
        global $con;

        $selectArticle = $con->prepare("SELECT * FROM articles a WHERE a.id = '".$artId."'");
        $selectArticle-> setFetchMode(PDO::FETCH_ASSOC);
        $selectArticle-> execute();
        $articleDetails = $selectArticle->fetchAll();
    
        $_SESSION['editedArtId'] = $articleDetails['id'];
        $_SESSION['editedArtTopic'] = $articleDetails['topic'];
        $_SESSION['editedArtTitle'] = $articleDetails['articleTitle'];
        $_SESSION['editedArtcontent'] = $articleDetails['content'];   
        
        $topic = $_SESSION['editedArtTopic'];
        $articleTitle = $_SESSION['editedArtTitle'];
        $body = $_SESSION['editedArtcontent'];
        /*
        TODO list:
            1. edit form action
            2. create a logic for choosing a topic using js function
            3.
        
        */
        echo '
            <div class="admin-form-div">
                <form id="post-article" method="POST" action="../req-handle.php?action=update-article" enctype="multipart/form-data" >
                    <fieldset>
                        <legend> מאמרים </legend>
                        <p>אפשרות לסמן מאמר בבחירה מרובה לשם מחיקה ובנוסף מקום להוספת מאמרים חדשים טקסט ותמונות</p>
                        <select id="topic" name="topic" required>
                            <option class="opt" value="nutri">תזונה</option>
                            <option class="opt" value="breath">נשימה</option>
                            <option class="opt" value="sleep">שינה</option>
                            <option class="opt" value="aware">מודעות</option>
                            <option class="opt" value="motion">תנועה</option>

                            <script> fetchedArticeTopic('.$topic.') </script>
                        </select>
                        <label for="topic">:נושא המאמר</label>
                        <br>
                        <input type="text" name="articleTitle" size="91" required value="'.$articleTitle.'">
                        <br><br>
                        <div id="article-body">
                            <label for="content" ></label>
                            <textarea name="content" id="content" value="'.$body.'" autofocus required cols="91" rows="20"></textarea>
                            <br>
                        </div>
                        <br><br>
                        <button name="update-article" value="update-article">עדכון המאמר</button>
                        <br><br>
                    </fieldset>
                </form>
            </div>
        ';

        $selectImages = $con->prepare("SELECT * FROM images i WHERE i.articleId = '".$artId."'");
        $selectImages->setFetchMode(PDO::FETCH_ASSOC);
        $selectImages->execute();
        $imagesArray = $selectImages->fetchAll();

        $printImagesArray = array();
        foreach ($imagesArray as $curr) {
            $dbImage = $curr['img'];
            $imageId = $curr['imageId'];
            $imageName = $curr['imageName'];
            $imageForPrinting = stristr($dbImage, "/myphp");
            echo '
                <tr>
                <td> <a role="button" href="../req-handle.php?action=delete-image" class="deleteImageBtn">עריכה</a> <input type="hidden" name="imgToDel" value="'.$imageId.'" class="imgToDel"> </td>
                <td><img src="'. $imageForPrinting .'" alt="'. $imageName .'" style="width:100px; padding: 20px" class="articleTableImages"> </td>
                </tr>
            ';

            array_push($printImagesArray, $imageForPrinting);
        }

    }

    public static function updateArticle($artId, $body, $topic, $articleTitle){
        global $con;
        $updateQuery = 
            'UPDATE articles 
            SET content = "'.$body.'",
            topic = "'.$topic.'", articlTitle = "'.$articleTitle.'"
            WHERE articles.id = "'.$artId.'"';
        $updateArticle = $con->prepare($updateQuery);
        $updateArticle->execute(); 
        //checking if query was succsesfully implemented
        if ($updateArticle > 0){
            echo ' The article <span>'. $articleTitle .'</span> was updated!';
        };
    }

    public static function deleteImages($imgToDel){
        global $con;

        $deleteImgQuery = $con->prepare('DELETE FROM images AS i WHERE i.imageId = "'.$imgToDel.'"');
        $deleteImgQuery->execute(); 
        //checking if query was succsesfully implemented
        if ($deleteImgQuery > 0){
            echo ' Image number <span>'. $imgToDel .'</span> was deleted!';
        };
    }
   
    public static function deleteArticle($artToDelId){
        global $con;
        
        $deleteArtQuery = $con->prepare('DELETE FROM articles AS a WHERE a.id = "'.$artToDelId.'"');
        $deleteArtQuery->execute();
        if ($deleteArtQuery > 0) {
            echo 'The article '. $artToDelId.' was deleted from the database permanently!';
        };
    }
}
?>