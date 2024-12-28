<?php
ob_start(); // Start output buffering
session_start(); // Start the session
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $learner_name = $_POST['learner_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email already exists
    $check_email_query = "SELECT L_Email FROM Learner WHERE L_Email = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, set query parameter and redirect back to authentication.php
        header("Location: ../authentication.php?duplicate=true");
        exit();
    }

    // Insert new learner into database
    $sql = "INSERT INTO Learner (L_Name, L_Email, L_Password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $learner_name, $email, $password);
    if ($stmt->execute() === TRUE) {
        // Get the learner ID of the newly inserted record
        $learner_id = $conn->insert_id;

        // Store learner name and learner ID in session
        $_SESSION['learner_name'] = $learner_name;
        $_SESSION['learner_id'] = $learner_id;

        $conn->close();
        header("Location: ../selection.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
ob_end_flush(); // End output buffering and flush output
?>
