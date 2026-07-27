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
    include '../audit_helper.php';
    require '../../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }
    $staff_id = trim($_POST['employer-id'] ?? '');
    $password = $_POST['password'] ?? '';
    if (empty($staff_id) || empty($password)) {
        echo json_encode([
            "status" => "error",
            "message" => "Employer ID and password are required."
        ]);
        exit;
    }
    if (!isset($conn) || $conn->connect_error) {
        throw new Exception("Database connection failed.");
    }
    $stmt = $conn->prepare("SELECT * FROM employer WHERE staff_id = ? LIMIT 1");
    $stmt->bind_param("s", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Employer ID not found."
        ]);
        exit;
    }
    $user = $result->fetch_assoc();
    if (!password_verify($password, $user['password'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid password."
        ]);
        exit;
    }
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['staff_id'] = $user['staff_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['department'] = $user['department'];
    $_SESSION['email'] = $user['email'];
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $update = $conn->prepare("UPDATE employer SET ip_address = ?, last_activity = NOW() WHERE staff_id = ?");
    $update->bind_param("ss", $ip_address, $staff_id);
    $update->execute();
    $update->close();
    if (function_exists('addAuditLog')) {
        addAuditLog(
            $conn,
            $user['username'],
            $user['department'] ?? 'N/A',
            "Login",
            "Employer {$user['username']} logged in successfully.",
            $ip_address
        );
    }
    if (!empty($user['login_alerts']) && (int)$user['login_alerts'] === 1) {

        try {

            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'alfonsosomo@gmail.com';
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom(
                'alfonsosomo@gmail.com',
                'Alfonso Somo Security'
            );

            $mail->addAddress($user['email']);

            $mail->isHTML(true);

            $mail->Subject = "New Login Alert";

            $mail->Body = "
                <h2>Login Alert</h2>

                <p>Your administrator account has logged in successfully.</p>

                <table cellpadding='6'>
                    <tr>
                        <td><strong>Staff ID:</strong></td>
                        <td>{$user['staff_id']}</td>
                    </tr>

                    <tr>
                        <td><strong>Username:</strong></td>
                        <td>{$user['username']}</td>
                    </tr>

                    <tr>
                        <td><strong>IP Address:</strong></td>
                        <td>{$ip_address}</td>
                    </tr>

                    <tr>
                        <td><strong>Date & Time:</strong></td>
                        <td>" . date("F d, Y h:i A") . "</td>
                    </tr>
                </table>

                <br>

                <p>If this wasn't you, please secure your account immediately.</p>
            ";

            $mail->send();

        } catch (Throwable $e) {
        }
    }

    echo json_encode([
        "status" => "success",
        "message" => "Login successful.",
        "user" => [
            "id" => $user['id'],
            "staff_id" => $user['staff_id'],
            "username" => $user['username'],
            "email" => $user['email'],
            "department" => $user['department'],
            "type" => $user['type']
        ]
    ]);

    $stmt->close();
    $conn->close();

} catch (Throwable $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);

}
?>