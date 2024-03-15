<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptchaSecret = '6LfXzJApAAAAAD_ByIeAfIecMnrlFVzxiJ4J6EVn';
    $response = $_POST['g-recaptcha-response'];

    $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$recaptchaSecret.'&response='.$response);
    $recaptcha = json_decode($recaptcha);

    if ($recaptcha->success) {
        // Form submission logic here. Example:
        $name = strip_tags(trim($_POST["name"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        // Send the email (adjust the mail() function as needed)
        $recipient = "nick@8bithive.com";
        $subject = "New contact from $name";
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";

        $email_headers = "From: marketing@8bithive.com";

        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Send success message to the user
            echo json_encode(array('success' => true, 'message' => 'Message sent successfully.'));
        } else {
            // Send error message to the user
            echo json_encode(array('success' => false, 'message' => 'An error occurred, and your message could not be sent.'));
        }
    } else {
        // Recaptcha failed
        echo json_encode(array('success' => false, 'message' => 'reCAPTCHA verification failed. Please try again.'));
    }
} else {
    // Invalid request
    echo json_encode(array('success' => false, 'message' => 'Invalid request.'));
}
?>
