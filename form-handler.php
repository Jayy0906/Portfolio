<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Email to site owner
    $to = "jayp962001@gmail.com"; // Replace with your own email
    $subject = "New Contact Form Submission";
    $body = "Name: $name\nEmail: $email\nMessage: $message";

    if (mail($to, $subject, $body)) {
        // Confirmation email to the user
        $userSubject = "Thank you for contacting us!";
        $userBody = "Hello $name,\n\nThank you for reaching out! We have received your message and will get back to you shortly.\n\nBest regards,\nYour Company Name";
        $headers = "From: jayp962001@gmail.com"; // Use an email address associated with your domain

        mail($email, $userSubject, $userBody, $headers);
        echo "Message sent successfully!";
    } else {
        echo "Failed to send message.";
    }
}
?>
