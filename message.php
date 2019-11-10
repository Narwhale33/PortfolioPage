<?php

// Settings 
$recipient = 'luganex6@gmail.com'; // Replace it with your e-mail address
$fromMail = 'luganex6@gmail.com'; // Replace it with the email address the generated message will be send from
$subject = 'Contact Form NEW MESSAGE FROM SENDER- domain.com'; // Replace it with subject that you want to see when you receive a message
$responses = [
    'invalid' => '', // When a data is invalid
    'success' => '',
    'error' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Serialize whole data
    $name = strip_tags(trim($_POST['name-field']));
    $name = str_replace(array('\r','\n'),array(' ',' '), $name);

    $email = trim(filter_var($_POST['email-field'], FILTER_SANITIZE_EMAIL));
    $message = trim($_POST['message-field']);

    // Validate whole data
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
        http_response_code(400);
        echo $responses['invalid'];
        exit;
    }

    // Set the message 
    $content =  "From: $name\nEmail: $email\n\nMessage:\n$message\n";
    $header = "From: $fromMail\r\nReply-To: $email\r\n";

    if (mail($recipient, $subject, $content, $header)) {
        http_response_code(200);
        echo $responses['success'];
    }
    else {
        http_response_code(500);
        echo $responses['error'];
    }
}
else {
    http_response_code(403);
    echo $responses['error'];
}
