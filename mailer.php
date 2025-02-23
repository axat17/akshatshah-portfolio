<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recipient email (your email)
    $mail_to = "axat17@gmail.com";

    // Sender Data
    $name    = strip_tags(trim($_POST["full-name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone   = isset($_POST["phone-number"]) ? trim($_POST["phone-number"]) : "Not provided";
    $message = trim($_POST["message"]);

    // Validate fields
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
        http_response_code(400);
        echo "Please fill in all required fields correctly.";
        exit;
    }

    // Email subject
    $subject = "New Contact Form Submission from $name";

    // Mail Content
    $content = "Name: $name\n";
    $content .= "Email: $email\n";
    $content .= "Phone: $phone\n\n";
    $content .= "Message:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    $success = mail($mail_to, $subject, $content, $headers);

    if ($success) {
        http_response_code(200);
        echo "Thank you! Your message has been sent successfully.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong, we couldn't send your message.";
    }

} else {
    http_response_code(403);
    echo "Invalid request method.";
}

?>
