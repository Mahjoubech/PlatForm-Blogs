<?php
class Article {
    private $cnx;
    private $id;
    private $userId;
    private $title;
    private $content;
    private $image;
    private $categoryId;
    // private $comments = [];
    // private $likes = [];
    public function __construct($db) {
        $this->cnx = $db;
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }
    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }
    public function getCategoryId() {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    // Method to fetch all articles
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

    // Create an article
    public function create($userId, $title, $content, $image, $categoryId) {
        $stmt = $this->cnx->prepare("INSERT INTO article (userId, title, content, image, categId) 
            VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$this->setUserId($userId), $this->setTitle($title), $content, $image, $categoryId]);
    }

    // Update an article
    public function update() {
        if ($this->id) {
            $stmt = $this->cnx->prepare("UPDATE article SET title = ?, content = ?, image = ?, categId = ? WHERE art_Id = ?");
            return $stmt->execute([$this->title, $this->content, $this->image, $this->categoryId, $this->id]);
        }
        return false;
    }

    // Delete an article
    public function delete() {
        if ($this->id) {
            $stmt = $this->cnx->prepare("DELETE FROM article WHERE art_Id = ?");
            return $stmt->execute([$this->id]);
        }
        return false;
    }
}
