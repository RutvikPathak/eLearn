<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_GET['peer_id'])) {
    header('Location: authentication.php');
    exit();
}

require_once('php/db.php'); // Adjust the path as per your file structure

$email = $_SESSION['email'];
$peer_id = $_GET['peer_id'];

// Fetch the current learner's ID
$sql = "SELECT LearnerID FROM Learner WHERE Email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $learner_id = $row['LearnerID'];

    // Check if a chat session already exists between the two learners
    $sql = "SELECT SessionID FROM ChatSessions 
            WHERE (LearnerID1='$learner_id' AND LearnerID2='$peer_id') 
               OR (LearnerID1='$peer_id' AND LearnerID2='$learner_id')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Chat session already exists, fetch the SessionID
        $row = $result->fetch_assoc();
        $session_id = $row['SessionID'];
    } else {
        // Create a new chat session
        $sql = "INSERT INTO ChatSessions (LearnerID1, LearnerID2, FieldID)
                VALUES ('$learner_id', '$peer_id', 
                (SELECT FieldID FROM LearnerFields WHERE LearnerID='$learner_id' LIMIT 1))";
        if ($conn->query($sql) === TRUE) {
            $session_id = $conn->insert_id; // Get the ID of the newly created session
        } else {
            die("Error creating chat session: " . $conn->error);
        }
    }

    // Redirect to the chat interface
    header("Location: chat.php?session_id=$session_id");
    exit();
} else {
    die("Error fetching learner ID: " . $conn->error);
}

$conn->close();
?>