<?php
// Include the database connection file
require_once('php/db.php');
session_start();

// Check if the learner's name and ID are set in the session
if (!isset($_SESSION['learner_name']) || !isset($_SESSION['learner_id'])) {
    // Redirect to the login page if not set
    header("Location: authentication.php");
    exit();
}

// Fetch IT fields from the database
$sql = "SELECT FieldID, FieldName FROM ITFields";
$result = $conn->query($sql);
?>


<!DOCTYPE html> 
<html lang="en"> 
<head> 
<title>Elearn</title> 
 <meta charset="utf-8"> 
 <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
 <meta name="description" content="Elearn project"> 
 <meta name="viewport" content="width=device-width, initial-scale=1"> 
 <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css"> 
 <link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
 <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css"> 
 <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css"> 
 <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css"> 
 <link href="plugins/video-js/video-js.css" rel="stylesheet" type="text/css"> 
 <link rel="stylesheet" type="text/css" href="styles/main_styles.css"> 
 <link rel="stylesheet" type="text/css" href="styles/responsive.css"> 
</head>
<style>
    /* Main navigation container styles */
    .main_nav_container {
        display: flex;
        justify-content: space-between; /* Space between logo and welcome message */
        align-items: center;
        padding: 10px;
        font-family: Arial, sans-serif;
        height: 60px; /* Adjust the height as needed */
        background-color: #f1f1f1; /* Light background color */
    }

    .logo_content {
        display: flex;
        align-items: center; /* Center align logo and text vertically */
    }

    .logo_img img {
        height: 40px; /* Adjust the logo image height as needed */
        margin-right: 10px; /* Space between logo image and text */
    }

    .logo_text {
        font-size: 24px;
        font-weight: bold;
        color: #333; /* Dark color for logo text */
    }

    /* Welcome message styles */
    .welcome-message {
        font-size: 18px;
        color: black;
    }

    /* Username styles */
    .username {
        font-size: 24px;
        font-weight: bold;
        color: orange; /* Orange color for the username */
        margin-left: 10px; /* Add some space between "Welcome," and the username */
        text-shadow: 1px 1px 2px black; /* Add shadow for better readability */
        font-style: italic; /* Italicize the username for emphasis */
    }

    /* Center-aligns the main heading */
    h1 { 
        text-align: center; 
    } 

    /* Removes the default list style and padding */
    ul { 
        list-style-type: none; 
        padding: 0; 
    } 

    /* Adds margin to list items, except for the last one */
    li { 
        margin-bottom: 10px; 
    } 

    li:last-child { 
        margin-bottom: 0; 
    } 

    /* Centers the button container and adds top margin */
    .button-container { 
        display: flex;
        flex-direction: column; /* Stack buttons vertically */
        align-items: center; /* Center the buttons horizontally */
        margin-top: 20px; 
    } 

    /* Styles the button */
    button { 
        background-color: #fff; 
        color: black; 
        padding: 10px 20px; 
        border: none; 
        border-radius: 20px; 
        cursor: pointer; 
        font-size: 16px; 
        transition: background-color 0.3s ease, color 0.3s ease; 
        margin: 10px 0; /* Add margin between buttons vertically */
    } 

    /* Changes button background and text color on hover */
    button:hover { 
        background-color: #ffa500; 
        color: white; 
    }
</style>



<body>
    <div class="super_container">
        <!-- Header -->
        <div class="main_nav_container">
            <div class="logo_content d-flex flex-row align-items-end justify-content-start">
                <div class="logo_img"><img src="images/logo.png" alt=""></div>
                <div class="logo_text">learn</div>
            </div>
            <span class="welcome-message">
                Welcome, <span class="username"><?php echo htmlspecialchars($_SESSION['learner_name']); ?>!</span>
            </span>
        </div>

        <br><br><br>
        <div>
            <h3 style="margin-left: 35%;">Choose the topics you are interested in most</h3>
            <div class="button-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<form method="POST" action="">';
                        echo '<input type="hidden" name="field_id" value="' . htmlspecialchars($row["FieldID"]) . '">';
                        echo '<p><button type="submit">' . htmlspecialchars($row["FieldName"]) . '</button></p>';
                        echo '</form>';
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['field_id'])) {
        $field_id = intval($_POST['field_id']);
        $learner_id = $_SESSION['learner_id']; // Ensure learner_id is stored in session

        // Insert the selection into LearnerFields table
        $stmt = $conn->prepare("INSERT INTO LearnerFields (LearnerID, FieldID) VALUES (?, ?)");
        $stmt->bind_param("ii", $learner_id, $field_id);
        if ($stmt->execute() === TRUE) {
            // Provide feedback to the user
            echo "<script>alert('Your selection has been recorded.'); window.location.href = 'authentication.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $conn->close();
    ?>

</body>
</html>
