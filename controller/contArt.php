<?php 
require_once '.././database/connexion.php';
require_once '.././class/Article.php';
$db = new DatabaseConnection();
$creat = new Article($db->getConnection());
// //add article 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addArt'])) {
    $user = $_SESSION['user']['useId'];
    $catg = $_POST['selectCat'];
    $title = $_POST['titleblog'];
    $img = $_POST['lienimage'];
    $desc = $_POST['descrp'];

    if (!empty($catg) && !empty($title) && !empty($img) && !empty($desc)) {
        // Insérer dans la base de données
        if (        $creat->create($user,$title,$desc,$img,$catg)
        ) {
            header('Location: article.php');
        } else {
            die("Erreur SQL : " . $db->getConnection()->error);
        }
    }
}
?>