<?php 
require_once './User.php';
class Client extends User{
    public function __construct($cnx) {
        parent ::__construct($cnx);
    }
    
}
?>