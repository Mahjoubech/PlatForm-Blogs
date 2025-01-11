<?php
 require_once '../database/connexion.php';
 require_once '../class/Category.php';
 $db = new DatabaseConnection();

$cat = new Category($db->getConnection());
//  //ajout category
 if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addcat'])){
    $nameCat = htmlspecialchars($_POST['namecat']);
    $cat->setName($nameCat);
    $errors = [];
    if (empty($nameCat)) {
        $errors[] = "< script > alert('invalid name') < /script>";
    }
    if (empty($errors)) {
        //insert into
        $cat->addCategory();
    header('Location: .././views/admin/category.php');
       exit;
       }else{
        $_SESSION['errors'] = $errors;
        print_r($_SESSION['errors']);
        unset($_SESSION['errors']);
        header('Location: .././views/admin/category.php');
        exit;
     }
}
//delet category
 if(isset($_GET['iddelcatgr'])){
    $catgrId = $_GET['iddelcatgr'];
    $cat->setId($catgrId);
    $cat->deletCategory();
 header('Location: .././views/admin/category.php');
 }
 //edi
 if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editcat'])){
    $id = $_GET['idcatgr'];
    $name = $_POST['nameedit'];
    $cat->setId($id);
    $cat->setName($name);
    $cat->editCategory();
 header('Location: .././views/admin/category.php');
    
}
  
