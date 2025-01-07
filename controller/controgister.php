<?php
 require_once  ".././database/connexion.php";
 require_once   ".././class/Client.php";
 $db = new DatabaseConnection();
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['btn_submit'])) {
  if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
       $username = $_POST['name'] ;
       $email = $_POST['email'] ;
       $password = $_POST['password'];
       $role = 1;
       var_dump($username, $email, $password, $role);   
   $register = new Client($db->getConnection());
   $register->register($username, $email, $password, $role);
   var_dump($register);

if ($register) {
    header('location: ../login.php');
}else{
    echo'hhhhhhhhhhhhhhh';
}
}
}
?>
