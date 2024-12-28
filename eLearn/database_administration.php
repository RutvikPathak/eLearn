<?php
include 'php/db.php';

// SQL query to fetch data from the Certifications table
$sqlCertifications = "SELECT CertificationID, CertificationName, certification_url FROM Certifications WHERE FieldID=4";
$resultCertifications = $conn->query($sqlCertifications);

// SQL query to fetch data from the Courses table
$sqlCourses = "SELECT CourseID, CourseName, Provider, URL, IsFree, Duration FROM Courses WHERE FieldID=4";
$resultCourses = $conn->query($sqlCourses);
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
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 18px;
        text-align: left;
    }
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }
    th {
        background-color: orange;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9; /* Light orange (or a very light shade close to white) */
    }
    tr:nth-child(odd) {
        background-color: #fff; /* White */
    }
    tr:hover {
        background-color: #ffe4b5; /* Light orange */
    }
    h1 {
        color: black;
        text-align: center;
        font-size: 2em;
        margin-bottom: 20px;
        margin-top: 20px;
    }
    .heading {
    background-color: orange;
    color: black;
    padding: 50px;
    font-size: 40px;
    font-weight: bold;
    font-family: Arial, sans-serif;
    text-align: center;
    margin-top: 10%;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Adjust shadow size and color as needed */
    }
</style>
</head>
<body>

<!-- Header -->
<?php include 'header.php'; ?>
<script>
    function showRoadmapContent(){
        document.getElementById("roadmap").style.display = "block";
        document.getElementById("course").style.display = "none";
        document.getElementById("certification").style.display = "none";
    }
    function showCourseContent(){
        document.getElementById("roadmap").style.display = "none";
        document.getElementById("course").style.display = "block";
        document.getElementById("certification").style.display = "none";
    }
    function showCertificationContent(){
        document.getElementById("roadmap").style.display = "none";
        document.getElementById("course").style.display = "none";
        document.getElementById("certification").style.display = "block";
    }
</script>
<h1 class="heading">Database Administration</h1>
<div class="super_container">
    <div style="margin-left:11%; margin-right:11%;margin-bottom:5%;">
        <div class="button-group" style="margin-left:35%;">
            <a href="#" class="button-link" onclick="showRoadmapContent()">Roadmap</a>
            <a href="#" class="button-link" onclick="showCourseContent()">Courses</a>
            <a href="#" class="button-link" onclick="showCertificationContent()">Certification</a>
        </div>

        <div id="roadmap" class="container roadmap">
            <h1>Roadmap</h1>
            <img src="images/database-administrator.jpg" style="display: block;margin: 0 auto 20px auto;border: 5px solid orange;border-radius: 10px;max-width: 100%;"> 
        </div>

        <div id="course" class="container course" style="display:none;">
            <h1>Course</h1>
            <table>
                <tr>
                    <th>Sr.</th>
                    <th>Course Name</th>
                    <th>Provider</th>
                    <th>IsFree</th>
                    <th>Duration</th>
                </tr>
                <?php
                    if ($resultCourses->num_rows > 0) {
                        $sr = 1; // Initialize serial number
                        // Output data of each row
                        while($row = $resultCourses->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $sr . "</td>";
                            echo "<td><a href='" . $row["URL"] . "' target='_blank'>" . $row["CourseName"] . "</a></td>";
                            echo "<td>" . $row["Provider"] . "</td>";
                            echo "<td>" . ($row["IsFree"] ? "Yes" : "No") . "</td>";
                            echo "<td>" . $row["Duration"] . "</td>";
                            echo "</tr>";
                            $sr++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                ?>
            </table>
        </div>

        <div id="certification" class="container certification" style="display:none;">
            <h1>Certification</h1>
            <table>
                <tr>
                    <th>Sr.</th>
                    <th>Name</th>
                </tr>
                <?php
                    if ($resultCertifications->num_rows > 0) {
                        // Output data of each row
                        $sr = 1; // Initialize serial number
                        while($row = $resultCertifications->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $sr . "</td>";
                            echo "<td><a href='" . $row["certification_url"] . "' target='_blank'>" . $row["CertificationName"] . "</a></td>";
                            echo "</tr>";
                            $sr++;
                        }
                    } else {
                        echo "<tr><td colspan='2'>No records found</td></tr>";
                    }
                ?>
            </table>
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