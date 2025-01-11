<?php 
require_Once 'User.php';
class Admin extends User{
    private $id;
    public function __construct($cnx) {
        parent ::__construct($cnx);
    }
    public function setId($id){
        $this->id = $id;
    }
    public  function getId(){
        return $this->id ;
    }
   public function DeletUser (){
     $delet = $this->cnx->prepare('DELETE FROM user WHERE useId=?');
     $delet->execute([$this->getId()]);
 
     }
     public function chngRole (){
        $change = $this->cnx->prepare('update user set role_id=1 WHERE useId=?');
        $change->execute([$this->getId()]);
    
     }
     
}


?>