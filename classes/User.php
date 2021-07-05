<?php 
include_once '../config.php';
class User{

    public $userName;
    public $userPass;
    public $confirmPass;
    public $userEmail;
    public $isAdmin = false;
    
// constracting an array to hold the data comming from the registration form
    public function __construct($userData = array()){
       if(isset($userData['name'])) $this->userName = $userData['name'];
       if(isset($userData['email'])) $this->userEmail = $userData['email'];
       if(isset($userData['pass'])) $this->userPass = $userData['pass'];
       if(isset($userData['confirmPass'])) $this->confirmPass = $userData['confirmPass'];

    //    try 
    //    {
    //        $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    //        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
    //    } 
    //    catch (PDOException $e) {
    //        echo "Error : " . $e->getMessage() . "<br/>";
    //        die();
    //    }
    }

    public static function checkLoginInformation($formData=array()){
        global $con;
        $email= $formData['email'];
        $pass = $formData['pass'];

        $select = $con->prepare("SELECT * FROM users WHERE email='$email' and pass='$pass'");
        $select->setFetchMode(PDO::FETCH_ASSOC);
        $select->execute();
        $fetchedData = $select->fetch();

        if($select->rowCount() > 0) {
            session_set_cookie_params(0);
            session_start();

            $_SESSION['id'] = $fetchedData['id'];
            $_SESSION['email'] = $fetchedData['email'];
            $_SESSION['pass'] = $fetchedData['pass'];
            $_SESSION['name'] = $fetchedData['userName']; 
            $_SESSION['isAdmin'] = $fetchedData['isAdmin']; 

        }
        else
        {
            include '../js-scripts.php';
            ?> <script>
                invalidPass();
            </script> <?php 
        }
    }
    
    public function newUser(){
        global $con;
        // checking if email exists in the DB
        $select = $con->prepare("SELECT * FROM users WHERE email='$this->userEmail'");
        $select->setFetchMode(PDO::FETCH_ASSOC);
        $select->execute();
        if ($select->rowCount() > 0) {
            include '../js-scripts.php'; ?> <script>
                emailAlreadyExists();
            </script> <?php
            header("location:http://localhost/myphp/peimot-class/pages/loginRegister.php");

        } elseif ($this->userPass === $this->confirmPass) {
            echo "<script> console.log(`inside elseif email: `" . $this->userEmail .");</script>"; 
            $createTable = $con->prepare(
                'CREATE TABLE IF NOT EXISTS users(
                id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                email varchar(60) NOT NULL,
                pass varchar(60)NOT NULL,
                userName varchar(60) NOT NULL,
                isAdmin boolean NOT NULL,
                PRIMARY KEY (id)
            );'
            );
            $createTable->execute();
            $insertQuery ="INSERT INTO `users`
                (`email`, `pass`, `userName`, `isAdmin`)
            VALUES
                (:email,:pass,:userName,:isAdmin)";

            $query = $con->prepare($insertQuery);
            $query->bindparam(':email', $this->userEmail);
            $query->bindparam(':pass', $this->userPass);
            $query->bindparam(':userName', $this->userName);
            $query->bindparam(':isAdmin', $this->isAdmin);
            $query->execute();

            $lastInsertId = $con->lastInsertId();
            if ($lastInsertId > 0) {
                $select = $con->prepare("SELECT * FROM users WHERE email='$this->userEmail' and pass='$this->userPass'");
                $select->setFetchMode(PDO::FETCH_ASSOC);
                $select->execute();
                $data = $select->fetch();

                if ($select->rowCount() > 0) {
                    session_set_cookie_params(0);
                    session_start();

                    $_SESSION['id'] = $data['id'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['pass'] = $data['pass'];
                    $_SESSION['name'] = $data['name'];
                    $_SESSION['isAdmin'] = $data['isAdmin'];

                    header("location:http://localhost/myphp/peimot-class/pages/home.php");
                } 
                else 
                {
                    echo "<h1>אירעה שגיאה</h1>";
                }
            } 
            else 
            {
                echo "<script>passConfirm($this->userPass,$this->confirmPass)</script>";
            }
        }
    }

    public static function logout(){
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        header("location:http://localhost/myphp/peimot-class/pages/home.php");
    }

}
?>