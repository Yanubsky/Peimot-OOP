<div class="admin-form-div">
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
<!--  -->
    <form id="post-article" method="POST" action="../req-handle.php?action=delete" enctype="multipart/form-data" >
        <fieldset>
            <legend> מאמרים </legend>
            <p>אפשרות לסמן מאמר בבחירה מרובה לשם מחיקה ובנוסף מקום להוספת מאמרים חדשים טקסט ותמונות</p>
            <select id="topic" name="topic" required>
                <option value="" disabled selected >בחר נושא</option>
                <option value="nutri">תזונה</option>
                <option value="breath">נשימה</option>
                <option value="sleep">שינה</option>
                <option value="aware">מודעות</option>
                <option value="motion">תנועה</option>
            </select>
            <label for="topic">:נושא המאמר</label>
            <br>
            <input type="text" name="articleTitle" size="91" required placeholder='כותרת'>
            <br><br>
            <div id="article-body">
                <label for="content" ></label>
                <textarea name="content" id="content" placeholder="...הכנס/הדבק טקסט" autofocus required cols="91" rows="20"></textarea>
                <br>
                <label for="articleImages">.אנא הוסף קבצי תמונות בלבד. חשוב לשמור על איכות תמונה גבוהה</label>
                <input type="file" name="articleImages[]" class="articleImages" multiple accept="image/*">
            </div>
            <br><br>
            <button name="post-article" value="post-article">פרסום המאמר</button>
            <br><br>
        </fieldset>
    </form>
</div>

<?php 
    include '../js-scripts.php';
?>


