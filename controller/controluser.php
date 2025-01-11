<?php
 require_once '../database/connexion.php';
 require_once '../class/Admin.php';
 $db = new DatabaseConnection();

$admin = new Admin($db->getConnection());

//delet user;
if(isset($_GET['idUser'])){
   $iduse = $_GET['idUser'];
   $admin->setId($iduse);
   $admin->DeletUser();
header('Location: .././views/admin/user.php');
}
// //chage user role;
if(isset($_GET['idrole'])){
    $iduse = $_GET['idrole'];
  $admin->setId($iduse);
  $admin->chngRole();
 header('Location: .././views/admin/user.php');
 }