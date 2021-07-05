<header class="header">
    <h1 class="logo"><a  href="./home.php">Here comes logo</a></h1>
    <ul class="main-nav">
        <div id="navbarGeneralTabsDiv">
            <li><a class="userCurrPage" id="about" href="./about.php">קצת עלי</a></li>
            <li><a class="userCurrPage" id="therapies" href="./therapies.php">טיפולים</a></li>
            <li><a class="userCurrPage" id="articles" href="./articles.php">מאמרים</a></li>
            <li><a class="userCurrPage" id="home" href="./home.php">עמוד הבית</a></li>
        </div>
        <div id="navbarProfileDiv">


            <?php 
                include '../classes/User.php';
                if(isset($_SESSION['email'])) {
                    $userProfile =  strtoupper(substr($_SESSION['email'], 0, 1));
                    $isAdmin = $_SESSION['isAdmin'];
                    if ($isAdmin != 0) {
                        echo "<div class='logoutDiv'>
                                <li>
                                    <form id='logout' method='POST' action='../req-handle.php?action=signout'>
                                        <a id='logout' value='signout' ><button type='submit' name='signout' id='signoutBtn' value='signout'>$userProfile</button></a>
                                    </form>
                                </li>
                             </div>";
                        echo "<li id='hammerIcon'> <a id='admin' href='./adminBackOffice.php'><i class='fas fa-hammer'></i></a></li>";

                    } 
                    else 
                    {
                        echo "<div class='logoutDiv'>
                             <li> 
                                <form id='logout' method='POST' action='../req-handle.php?action=signout'>
                                   <button type='submit' name='signout' id='signoutBtn' value='signout'> <a id='logout' value='signout' >$userProfile</a></button>
                                </form>
                            </li>
                        </div>";

                    }
                } 
            
            ?>
        </div>

       
    </ul>

</header>