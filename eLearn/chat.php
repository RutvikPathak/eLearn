<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_GET['session_id'])) {
    header('Location: authentication.php');
    exit();
}

require_once('php/db.php'); // Adjust the path as per your file structure

$session_id = $_GET['session_id'];
$email = $_SESSION['email'];

// Fetch the current learner's ID
$sql = "SELECT LearnerID FROM Learner WHERE Email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $learner_id = $row['LearnerID'];
} else {
    die("Error fetching learner ID: " . $conn->error);
}

// Fetch messages in the chat session
$sql = "SELECT m.MessageText, m.Timestamp, l.Name AS SenderName 
        FROM ChatMessages m
        JOIN Learner l ON m.SenderLearnerID = l.LearnerID
        WHERE m.SessionID='$session_id'
        ORDER BY m.Timestamp ASC";
$messages_result = $conn->query($sql);

// Handle new message submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
    $sql = "INSERT INTO ChatMessages (SessionID, SenderLearnerID, MessageText)
            VALUES ('$session_id', '$learner_id', '$message')";
    if ($conn->query($sql) === TRUE) {
        header("Location: chat.php?session_id=$session_id");
        exit();
    } else {
        die("Error sending message: " . $conn->error);
    }
}

$conn->close();
?>

<h1>Chat</h1>
<div class="chat-container">
    <div class="messages">
        <?php if ($messages_result->num_rows > 0): ?>
            <?php while ($message = $messages_result->fetch_assoc()): ?>
                <p><strong><?php echo htmlspecialchars($message['SenderName']); ?>:</strong> <?php echo htmlspecialchars($message['MessageText']); ?> <small><?php echo htmlspecialchars($message['Timestamp']); ?></small></p>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No messages yet.</p>
        <?php endif; ?>
    </div>
    <form method="POST" action="">
        <textarea name="message" rows="4" cols="50" placeholder="Type your message..."></textarea><br>
        <button type="submit">Send</button>
    </form>
</div>
