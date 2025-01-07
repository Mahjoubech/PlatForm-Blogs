<?php
require_once 'User.php';
class Client extends User
{
    public function login($email, $password): bool
    {
        $stmt = $this->cnx->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $client = $stmt->fetch();
        var_dump($client["role_id"]);
        if ($client) {
        if ($this->verifyPassword($password, $client['password']) && $client['role_id'] == 2) {
            header('location: .././views/client.php');
            $this->createSession($client);
            } else {
                header('location: .././views/admin.php');
                $this->createSession($client);
            }
            return true;
    }

    }
    public function register($username, $email, $password, $role)
    {
        $stmt = $this->cnx->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['emaildija'] = "Cet email est déjà utilisé. Veuillez utiliser un autre email.";
            header("Location: ../Register.php");
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hachage du mot de passe
        $stmt = $this->cnx->prepare("INSERT INTO user (username, email, password, role_id) VALUES (:username, :email, :password, :role)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $_SESSION['ressie'] = "Inscription réussie !";
            return  $_SESSION['ressie'];
        } else {
            $_SESSION['errrinsc'] =  throw new Exception("Erreur lors de l'inscription. Veuillez réessayer.");
        }
    }
}
