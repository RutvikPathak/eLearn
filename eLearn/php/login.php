<?php
session_start();
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM learner WHERE L_Email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Ensure 'L_Password' key exists in the row
        if ($password == $row['L_Password']) { // Compare plain text passwords
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row['L_Name']; // Store the learner's name in the session
            header('Location: ../home.php');
            exit();
        } else {
            echo "<script>alert('Password incorrect!'); window.location.href = '../authentication.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href = '../authentication.php';</script>";
    }
}

$conn->close();
?>
