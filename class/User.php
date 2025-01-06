<?php 
session_start();
 abstract class User {
     protected $cnx;
     public function __construct($cnx) {
        $this->cnx = $cnx;
     }
     abstract public function login($email, $password): bool;
    
     protected function verifyPassword($password, $hashedPassword): bool {
         return password_verify($password, $hashedPassword);
     }
 
     public function logout(): void {
         session_start();
         session_destroy();
         session_unset();
     }
 
     protected function createSession($userData): void {
         session_start();
         $_SESSION['user_id'] = $userData['id'];
         $_SESSION['role'] = $userData['role'];
         $_SESSION['username'] = $userData['username'];
     }
}
?>