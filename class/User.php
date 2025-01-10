<?php 
session_start();
abstract class User{
    protected $username;
    protected $email;
    protected $password;
    protected $role;
    protected $cnx;
    public function __construct($cnx) {
        $this->cnx = $cnx;
    }
    public function setUsername($username): void {
        $this->username = $username;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setPassword($password): void {
        $this->password = password_hash($password, PASSWORD_BCRYPT); 
    }

    public function setRole($role): void {
        $this->role = $role;
    }
    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRole(): string {
        return $this->role;
    }
    protected function verifyPassword($password, $hashedPassword): bool {
        return password_verify($password, $hashedPassword);
    }
    public function logout(): void {
        session_start();
        session_destroy();
        session_unset();
    }
}
?>