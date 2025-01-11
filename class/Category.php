<?php 
class Category{
    private $id;
    private $name;
    private $cnx;
    public function __construct($db) {
        $this->cnx = $db;
    }
    public function setId($id){
        $this->id = $id;
    }
    public  function getId(){
        return $this->id ;
    }
    public function setName($name){
        $this->name = $name;
    }
    public  function getName(){
        return $this->name ;
    }
   public function getAllCategory(){
    $sql = $this->cnx->prepare('SELECT * from category order by catId Asc');
        $sql->execute();
       return $sql->fetchAll(PDO::FETCH_ASSOC);
 
     }
     public function chngRole (){
        $change = $this->cnx->prepare('update user set role_id=1 WHERE useId=?');
        $change->execute([$this->getId()]);
    
     }
     public function addCategory(){
      $sql = $this->cnx->prepare('INSERT INTO category(name) VALUES (?)');
      $sql->execute([$this->getName()]);
     }
     public function deletCategory(){
        $delet = $this->cnx->prepare('DELETE FROM category WHERE catId=?');
        $delet->execute([$this->getId()]); 
       }
       public function getCategoryId(){
        $get = $this->cnx->prepare('SELECT * FROM `category` WHERE catId = ?');
        $get->execute([$this->getId()]); 
        return $get->fetchAll(PDO::FETCH_ASSOC);
       }
}


?>