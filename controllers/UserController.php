<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function register($data) {
        try {
            if ($data['password'] !== $data['confirm_password']) {
                $_SESSION['error'] = "Passwords do not match";
                header("Location: ../views/user/register.php");
                return;
            }
            $this->user->username = $data['username'];
            $this->user->email = $data['email'];
            $this->user->password = $data['password'];
            $this->user->phone_number = $data['phone_number'];
            if ($this->user->create()) {
                $sql = "SELECT id, username FROM users WHERE email = :email";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":email", $data['email']);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['success'] = "Registration successful! Welcome to SouqCycle!";

                header("Location: ../index.php");
                exit();
            } else {
                $_SESSION['error'] = "Registration failed. Please try again.";
                header("Location: ../views/user/register.php");
                exit();
            }
        } catch(PDOException $e) {
            $_SESSION['error'] = "Registration failed. Please try again.";
            header("Location: ../views/user/register.php");
            exit();
        }
    }
    public function login($data) {
        try {
            $sql = "SELECT id, username, password, is_admin FROM users WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $email = $data['email'];
            $password = $data['password'];
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            
            if($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if(password_verify($password, $user['password'])) {
                    error_log("Login successful - User: " . $user['username']);
                    
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['is_admin'] = $user['is_admin'];
                    $_SESSION['is_logged_in'] = true;
                    
                    error_log("Session data set: " . print_r($_SESSION, true));
                    
                    if($user['is_admin']) {
                        header("Location: ../views/admin/dashboard.php");
                    } else {
                        header("Location: ../index.php");
                    }
                    exit();
                }
            }
            $_SESSION['error'] = "Invalid credentials";
            header("Location: ../views/user/login.php?error=invalid_credentials");
            exit();
        } catch(PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $_SESSION['error'] = "Login failed. Please try again.";
            header("Location: ../views/user/login.php");
            exit();
        }
     }
    public function logout() {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION = array();

            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 3600, '/');
            }
            session_destroy();
            setcookie('remember_me', '', time() - 3600, '/');
            setcookie('user_id', '', time() - 3600, '/');
            setcookie('user_email', '', time() - 3600, '/');
            header("Location: ../index.php");
            exit();
            
        } catch (Exception $e) {
            error_log("Logout error: " . $e->getMessage());
            header("Location: ../index.php?error=logout_failed");
            exit();
        }
    }
    
    public function getUserProfile($userId) {
        $query = "SELECT id, username, email, phone_number, registration_date 
                  FROM users 
                  WHERE id = :id";
                  
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $userId);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $_SESSION['error'] = "Error retrieving user profile";
            return false;
        }
    }
    public function getTotalUsers() {
    $query = "SELECT COUNT(*) as total FROM users";
    try {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    } catch(PDOException $e) {
        return 0;
    }
}
public function getAllUsers() {
    $query = "SELECT * FROM users ORDER BY registration_date DESC";
    try {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return false;
    }
}

public function toggleAdminStatus($userId) {
    if ($userId == $_SESSION['user_id']) {
        $_SESSION['error'] = "You cannot change your own admin status";
        return false;
    }

    $query = "UPDATE users SET is_admin = NOT is_admin WHERE id = :id";
    try {
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $userId);
        return $stmt->execute();
    } catch(PDOException $e) {
        return false;
    }
}

public function deleteUser($userId) {
    try {
        if ($userId == $_SESSION['user_id']) {
            $_SESSION['error'] = "You cannot delete your own account";
            return false;
        }

        error_log("Starting delete user process for ID: " . $userId);

        $this->db->beginTransaction();
        $checkQuery = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($checkQuery);
        $stmt->execute([':id' => $userId]);
        
        if (!$stmt->fetch()) {
            error_log("User not found: " . $userId);
            throw new Exception("User not found");
        }
        $query = "DELETE FROM products WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        error_log("Deleted products for user: " . $userId);
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $userId]);
        error_log("User deleted: " . $userId);

        $this->db->commit();
        return true;

    } catch(Exception $e) {
        $this->db->rollBack();
        error_log("Delete user error: " . $e->getMessage());
        return false;
    }
}
    
}
$controller = new UserController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch($_POST['action']) {
        case 'register':
            $controller->register($_POST);
            break;
        case 'login':
            $controller->login($_POST);
            break;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch($_POST['action']) {
        case 'register':
            $controller->register($_POST);
            break;
        case 'login':
            $controller->login($_POST);
            break;
        case 'toggle_admin':
            if($controller->toggleAdminStatus($_POST['user_id'])) {
                $_SESSION['success'] = "User admin status updated successfully";
            } else {
                $_SESSION['error'] = "Failed to update user admin status";
            }
            header("Location: ../views/admin/users/list.php");
            break;
            case 'delete_user':
                error_log("Delete user request for ID: " . $_POST['user_id']);
                
                try {
                    if ($controller->deleteUser($_POST['user_id'])) {
                        $_SESSION['success'] = "User deleted successfully";
                    } else {
                        throw new Exception("Failed to delete user");
                    }
                } catch (Exception $e) {
                    error_log("Delete error: " . $e->getMessage());
                    $_SESSION['error'] = "Failed to delete user";
                }
                
                header("Location: ../views/admin/users/list.php");
                exit();
                break;
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['action']) && $_GET['action'] == 'logout') {
        $controller->logout();
    }
}
?>