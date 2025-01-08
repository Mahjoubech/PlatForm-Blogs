<?php
class Article {
    private $cnx;

    // Composition : Liste des commentaires et des likes
    private $comments = [];
    private $likes = [];

    public function __construct($db) {
        $this->cnx = $db;
    }
    public function getAllArticles() {
        $sql = $this->cnx->prepare('
            SELECT article.*, user.username as name, category.name as catname
            FROM article
            JOIN user ON article.userId = user.useId
            JOIN category ON article.categId = category.catId
        ');
        $sql->execute();
       return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    //creat art
    public function create($userId, $title, $content, $image, $categoryId) {
        $stmt = $this->cnx->prepare("INSERT INTO article (userId, title, content, image, categId) 
            VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $title, $content, $image, $categoryId]);
       $id = $this->cnx->lastInsertId(); 
        return $id;
    }
    //  // Update an article
    //  public function update($id) {
    //     if ($id) {
    //         $stmt = $this->cnx->prepare("UPDATE article SET title = ?, content = ?, image = ?, categId = ? WHERE art_Id = ?");
    //         $stmt->execute([$this->title, $this->content, $this->image, $this->categoryId, $id]);
    //         return true;
    //     }
    //     return false;
    // }
    //  // Delete an article
    //  public function delete($id) {
    //     if ($this->id) {
    //         $stmt = $this->cnx->prepare("DELETE FROM article WHERE art_Id = ?");
    //         $stmt->execute([$this->id]);
    //         return true;
    //     }
    //     return false;
    // }
    // // Méthode pour charger les commentaires
    // public function loadComments($db) {
    //     $stmt = $db->prepare("SELECT * FROM comments WHERE article_id = ?");
    //     $stmt->execute([$this->id]);
    //     $results = $stmt->fetchAll();

    //     foreach ($results as $row) {
    //         $this->comments[] = new Comment($row['cmmlId'], $row['article_id'], $row['user_id'], $row['visit_name'], $row['cmnter'], $row['created_at']);
    //     }
    // }

    // // Méthode pour charger les likes
    // public function loadLikes($db) {
    //     $stmt = $db->prepare("SELECT * FROM likes WHERE article_id = ?");
    //     $stmt->execute([$this->id]);
    //     $results = $stmt->fetchAll();

    //     foreach ($results as $row) {
    //         $this->likes[] = new Like($row['likeId'], $row['article_id'], $row['userId'], $row['created_at']);
    //     }
    // }

    // // Getter pour les commentaires
    // public function getComments() {
    //     return $this->comments;
    // }

    // // Getter pour les likes
    // public function getLikes() {
    //     return $this->likes;
    // }
}
