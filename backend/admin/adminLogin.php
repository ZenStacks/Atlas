<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
session_start();
header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../conn.php';
    require_once __DIR__ . '/../audit_helper.php';
    require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/Exception.php';
    require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            echo json_encode([
                "status" => "error",
                "message" => "Email and password are required."
            ]);
            exit;
        }
        
        if (!isset($conn) || $conn->connect_error) {
            throw new Exception("Database connection failed or variable \$conn is missing.");
        }
        
        $stmt = $conn->prepare("SELECT * FROM employer WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['department'] = $user['department'];
                $_SESSION['user_id'] = $user['id'];
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $update = $conn->prepare("UPDATE employer SET ip_address = ?, last_activity = NOW() WHERE email = ?");
                $update->bind_param("ss", $ip_address, $email);
                $update->execute();
                $update->close();
                
                if (function_exists('addAuditLog')) {
                    addAuditLog(
                        $conn,
                        $user['username'],
                        $user['department'] ?? 'N/A',
                        "Login",
                        "Employer {$user['username']} logged in successfully",
                        $ip_address
                    );
                }
                
                if (isset($user['login_alerts']) && (int)$user['login_alerts'] === 1) {
                    try {
                        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
                        $dotenv->load();
                        $smtpPass = $_ENV['SMTP_PASS'];
                        $smtpUser = $_ENV['SMTP_USER'];
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = $smtpUser;
                        $mail->Password  = $smtpPass; 
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                        $mail->setFrom($smtpUser, 'Alfonso Somo Security');
                        $mail->addAddress($user['email']);
                        $mail->isHTML(true);
                        $mail->Subject = 'New Login Alert';
                        $mail->Body    = "
                            <h2>Login Alert</h2>
                            <p>Your account was logged in successfully.</p>
                            <p><strong>Username:</strong> " . ($user['username'] ?? 'User') . "</p>
                            <p><strong>IP Address:</strong> {$ip_address}</p>
                            <p><strong>Time:</strong> " . date("F d, Y h:i A") . "</p>
                            <br>
                            <p>If this was not you, secure your account immediately.</p>
                        ";

                        $mail->send();
                    } catch (\Throwable $mailException) {
                    }
                }

                echo json_encode([
                    "status" => "success",
                    "message" => "Login successful.",
                    "user" => [
                        "id" => $user['id'] ?? null,
                        "name" => $user['name'] ?? null,
                        "email" => $user['email'] ?? null,
                        "username" => $user['username'] ?? null,
                        "type" => $user['type'] ?? null
                    ]
                ]);

            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid password."
                ]);
            }

        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Email not found."
            ]);
        }

        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }

} catch (\Throwable $fatalError) {
    echo json_encode([
        "status" => "error",
        "message" => "PHP Fatal Error: " . $fatalError->getMessage() . " inside " . $fatalError->getFile() . " on line " . $fatalError->getLine()
    ]);
    exit;
}
?>