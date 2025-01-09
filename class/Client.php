<?php
require_once 'User.php';
class Client extends User {
    public function login($email, $password): bool {
        $stmt = $this->cnx->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $client = $stmt->fetch();

        if ($client) {
            if ($this->verifyPassword($password, $client['password']) && $client['role_id'] == 2) {
                $this->setUsername($client['username']);
                $this->setEmail($client['email']);
                $this->setRole($client['role_id']);

                $_SESSION['user'] = $client;
                header('Location: .././views/client.php');
            } else {
                $_SESSION['user'] = $client;
                header('Location: .././views/admin/article.php');
            }
            return true;
        }

        return false; 
    }

    public function register($username, $email, $password, $role) {
        $stmt = $this->cnx->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['emaildija'] = "Cet email est déjà utilisé. Veuillez utiliser un autre email.";
            header("Location: ../Register.php");
            exit();
        }
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setRole($role);
        $stmt = $this->cnx->prepare("INSERT INTO user (username, email, password, role_id) VALUES (:username, :email, :password, :role)");
        $stmt->bindParam(':username', $this->getUsername(), PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->getEmail(), PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->getPassword(), PDO::PARAM_STR);
        $stmt->bindParam(':role', $this->getRole(), PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['ressie'] = "Inscription réussie !";
            return $_SESSION['ressie'];
        } else {
            throw new Exception("Erreur lors de l'inscription. Veuillez réessayer.");
        }
    }
}
