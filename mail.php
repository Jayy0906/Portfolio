<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot trap
    if (!empty($_POST['website'])) {
        die("Bot detected.");
    }

    // CAPTCHA check
    if (trim($_POST['captcha']) !== "8") {
        die("Captcha failed. Try again.");
    }

    // Sanitize form input
    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));
    $subject = "New Contact Message from $name";

    // Simple spam filters
    if (preg_match('/http|https|href|tinyurl|bit\.ly/i', $message)) {
        die("Links are not allowed.");
    }
    if (preg_match('/[а-яА-ЯЁё]/u', $name)) {
        die("Name must use English characters.");
    }

    // Your Gmail credentials
    $yourEmail = 'patljoy8@gmail.com';        // Replace with your Gmail
    $appPass   = 'xxzq iefl tguy prsl';       // Replace with your Gmail App Password

    try {
        // Main email to you
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $yourEmail;
        $mail->Password   = $appPass;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom($yourEmail, 'Website Contact');
        $mail->addAddress($yourEmail, 'Your Name');
        $mail->addReplyTo($email, $name);
        $mail->Subject = $subject;
        $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $mail->send();

        // Auto-reply to user
        $reply = new PHPMailer(true);
        $reply->isSMTP();
        $reply->Host       = 'smtp.gmail.com';
        $reply->SMTPAuth   = true;
        $reply->Username   = $yourEmail;
        $reply->Password   = $appPass;
        $reply->SMTPSecure = 'tls';
        $reply->Port       = 587;

        $reply->setFrom($yourEmail, 'Jay Patel');
        $reply->addAddress($email, $name);
        $reply->Subject = "Thanks for reaching out!";
        $reply->Body    = "Hi $name,\n\nThank you for your message. We'll get back to you shortly!\n\n- Jay Patel";
        $reply->send();

        echo "✅ Thank you for your message!";
    } catch (Exception $e) {
        echo "❌ Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Invalid request method.";
}
?>
