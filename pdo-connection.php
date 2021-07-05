<?php
require_once 'config.php';
try 
{
    $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} 
catch (PDOException $e) {
    echo "Error : " . $e->getMessage() . "<br/>";
    die();
}

?>
