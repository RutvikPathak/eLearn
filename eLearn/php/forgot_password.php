<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate email (you can add more validation if needed)

    // Check if the email exists in the database
    require_once('db.php');

    $check_email_query = "SELECT * FROM Learner WHERE L_Email = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Email exists, generate a unique token and send a password reset link
        $row = $result->fetch_assoc();
        $learner_id = $row['LearnerID'];

        // Generate a unique token (you can use PHP's built-in functions or libraries like PHPMailer)
        $reset_token = bin2hex(random_bytes(32)); // Example of generating a random token

        // Store the token in the database
        $update_token_query = "UPDATE Learner SET ResetToken = ? WHERE LearnerID = ?";
        $stmt = $conn->prepare($update_token_query);
        $stmt->bind_param("si", $reset_token, $learner_id);
        $stmt->execute();

        // Send the password reset link via email (you can use PHPMailer or other email libraries)
        $reset_link = "http://yourwebsite.com/reset_password.php?token=" . $reset_token;

        // Example of sending email
        $to = $email;
        $subject = 'Password Reset Link';
        $message = 'Click on the following link to reset your password: ' . $reset_link;
        $headers = 'From: your-email@example.com' . "\r\n" .
            'Reply-To: your-email@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        // Provide feedback to the user
        echo "<script>alert('Password reset link has been sent to your email.');</script>";
    } else {
        echo "<script>alert('Email address not found. Please try again.');</script>";
    }

    $conn->close();
}
?>