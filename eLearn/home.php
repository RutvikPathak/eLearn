<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: authentication.php');
    exit();
}

require_once('php/db.php'); // Adjust the path as per your file structure

// Fetch learner's name, IT field, and FieldID based on email
$email = $_SESSION['email'];
$sql = "SELECT l.L_Name, f.FieldName, f.FieldID
        FROM learner l
        LEFT JOIN learnerfields lf ON l.LearnerID = lf.LearnerID
        LEFT JOIN itfields f ON lf.FieldID = f.FieldID
        WHERE l.L_Email='$email'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $learner_name = $row['L_Name'];
    $field_name = $row['FieldName'];
    $field_id = $row['FieldID'];
} else {
    // Handle case where user not found, though ideally this shouldn't happen if email is properly managed
    $learner_name = 'Learner';
    $field_name = 'No Field Selected';
    $field_id = null; // No valid FieldID
}

$conn->close();

// Determine the image to show based on FieldID
switch ($field_id) {
    case 1:
        $image_path = "images/software_developer.png";
        break;
    case 2:
        $image_path = "images/devops.png";
        break;
    case 3:
        $image_path = "images/network_security.png";
        break;
    case 4:
        $image_path = "images/database_Administration.png";
        break;
    case 5:
        $image_path = "images/software_tester.png";
        break;
    default:
        $image_path = "images/default.png"; // Default image if FieldID is not set
        break;
}
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .featured_row {
        display: flex;
        flex-wrap: wrap;
    }
    .featured_col {
        display: flex;
        width: 100%;
    }
    .featured_content, .featured_background {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px; /* Adjust padding as needed */
    }
    .featured_content {
        background-color: #f9f9f9; /* Optional: background color for content */
    }
    .featured_background {
        background-color: orange; /* Ensure the background color matches */
    }
    .featured_image {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }
    .button-group {
        display: flex;
        gap: 10px; /* Adds space between buttons */
    }
    .button-link {
        padding: 10px 20px; /* Adjust padding as needed */
        background-color: orange;
        color: #fff; /* Button text color */
        text-decoration: none; /* Remove underline */
        border-radius: 5px; /* Rounded corners */
        transition: background-color 0.3s ease; /* Smooth hover effect */
    }
    .button-link:hover {
        background-color: black; /* Darker background color on hover */
        color: white;
    }
</style>
</head>
<body>

<!-- Header -->
<?php include 'header.php'; ?>

<div class="super_container" style="margin-top: 10%;">

	<div style="margin-left:11%; margin-right:11%;margin-bottom:5%;">

	<h1>Welcome, <span style="font-weight: bold; color: orange; margin-left: 10px;"><?php echo htmlspecialchars($learner_name); ?></span>!</h1>
    

    <div class="row featured_row">
    <div class="featured_col">
        <div class="featured_content">
            <div class="featured_title">
                <h3><?php echo htmlspecialchars($field_name); ?></h3>
            </div>
            <div class="featured_text" style="text-align: justify; margin-bottom:3%;">
                To gain further insights into your chosen profession and understand the courses, please visit the course page. Completing the certification will provide you with practical experience. Additionally, connect with peers to discuss similar professions and share insights.
            </div>
            <div class="button-group">
                <a href="<?php echo strtolower(str_replace(' ', '_', $field_name)); ?>.php" class="button-link">Go to Roadmap</a>
                <a href="peers.php" class="button-link">Talk to your Peers</a>
            </div>
        </div>

        <!-- Background image artist https://unsplash.com/@jtylernix -->
        <div class="featured_background">
            <img src="<?php echo $image_path; ?>" class="featured_image">
        </div>
    </div>
	</div>
	

	</div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>


<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/greensock/TweenMax.min.js"></script>
<script src="plugins/greensock/TimelineMax.min.js"></script>
<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="plugins/greensock/animation.gsap.min.js"></script>
<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="plugins/video-js/video.min.js"></script>
<script src="plugins/video-js/Youtube.min.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>