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

if ($field_id !== null) {
    // Fetch peers with the same FieldID
    $sql_peers = "SELECT l.L_Name, l.L_Email 
                  FROM learner l
                  LEFT JOIN learnerfields lf ON l.LearnerID = lf.LearnerID
                  WHERE lf.FieldID='$field_id' AND l.L_Email != '$email'"; // Exclude current user

    $peers_result = $conn->query($sql_peers);
}

$conn->close();
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
    padding: 60px;
    font-size: 50px;
    font-weight: bold;
    font-family: Arial, sans-serif;
    text-align: center;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Adjust shadow size and color as needed */
    }
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        list-style-type: none;
        padding: 0;
    }

    .grid-item {
        background-color: #ffebcc; /* Light orange background */
        padding: 15px;
        border: 1px solid #ffa500; /* Light orange border */
        border-radius: 8px;
        text-align: center;
        color: #333; /* Dark text for contrast */
    }

    .grid-item:hover {
        background-color: #ffcc80; /* Darker orange on hover */
        border-color: #ff8c00; /* Darker border on hover */
    }

    .hidden {
        display: none;
    }

    .pagination {
        text-align: center;
        margin-top: 20px;
    }

    .pagination button {
        padding: 10px 20px;
        margin: 0 10px;
        background-color: #ffa500;
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
    }

    .pagination button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .popup {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    
    .popup-content {
        background-color: #fefefe;
        margin: 10% auto; /* Centered */
        padding: 20px;
        border: 1px solid #888;
        width: 50%; /* Adjust as needed */
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .popup-heading {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .popup-field {
        margin-bottom: 15px;
    }

    .popup-label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .popup-input,
    .popup-textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .popup-textarea {
        height: 100px;
    }

    .popup-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .popup-button:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>

<!-- Header -->
<?php include 'header.php'; ?>

<h1 class="heading"><?php echo htmlspecialchars($field_name); ?></h1>
<div class="super_container">
    <div style="margin-left:11%; margin-right:11%;margin-bottom:5%;">
        <!-- Styled search bar -->
        <form method="GET" action="" style="text-align:center; margin-bottom:20px;">
            <input type="text" name="search" placeholder="Search peers..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                   style="padding: 10px; width: 60%; border: 2px solid #FFA500; border-radius: 5px; margin-right: 10px;">
            <button type="submit" style="padding: 10px 20px; background-color: #FFA500; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Search
            </button>
        </form>
        
        <?php if (isset($peers_result) && $peers_result->num_rows > 0): ?>
    <ul class="grid-container">
        <?php 
        $count = 0;
        while ($peer = $peers_result->fetch_assoc()): 
            // Apply search filter
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = htmlspecialchars($_GET['search']);
                if (stripos($peer['L_Name'], $search) === false) {
                    continue;
                }
            }
        ?>
            <li class="grid-item<?php echo $count >= 25 ? ' hidden' : ''; ?>" data-name="<?php echo htmlspecialchars($peer['L_Name']); ?>" data-email="<?php echo htmlspecialchars($peer['L_Email']); ?>">
            <?php echo htmlspecialchars($peer['L_Name']); ?>
            </li>
            <?php $count++; ?>
        <?php endwhile; ?>
        </ul>
        <?php if ($count > 25): ?>
             <div class="pagination">
                    <button id="prevBtn" disabled>Previous</button>
                    <button id="nextBtn">Next</button>
             </div>
        <?php endif; ?>
        <?php else: ?>
            <p>No peers found in the same field.</p>
        <?php endif; ?>


        <div id="popup" class="popup">
    <div class="popup-content">
         <span class="close">&times;</span>
         <h2 id="popup-name" class="popup-heading"></h2>
         <div class="popup-field">
             <label for="popup-email" class="popup-label">Email:</label>
             <input type="email" id="popup-email" class="popup-input" readonly>
         </div>
         <div class="popup-field">
             <label for="popup-subject" class="popup-label">Subject:</label>
             <input type="text" id="popup-subject" class="popup-input">
         </div>
         <div class="popup-field">
             <label for="popup-message" class="popup-label">Message:</label>
             <textarea id="popup-message" class="popup-textarea"></textarea>
         </div>
         <button id="popup-send" class="popup-button">Send</button>
    </div>
</div>

    </div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsPerPage = 25;
        let currentPage = 1;
        const items = document.querySelectorAll('.grid-item');
        const totalPages = Math.ceil(items.length / itemsPerPage);

        function updatePagination() {
            items.forEach((item, index) => {
                item.classList.add('hidden');
                if (index >= (currentPage - 1) * itemsPerPage && index < currentPage * itemsPerPage) {
                    item.classList.remove('hidden');
                }
            });
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages;
        }

        document.getElementById('prevBtn').addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                updatePagination();
            }
        });

        document.getElementById('nextBtn').addEventListener('click', function() {
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
            }
        });

        updatePagination();
    });

    document.addEventListener('DOMContentLoaded', (event) => {
        const popup = document.getElementById('popup');
        const popupName = document.getElementById('popup-name');
        const popupEmail = document.getElementById('popup-email');
        const closeBtn = document.getElementsByClassName('close')[0];
        
        document.querySelectorAll('.grid-item').forEach(item => {
            item.addEventListener('click', () => {
                const name = item.getAttribute('data-name');
                const email = item.getAttribute('data-email');
                popupName.textContent = name;
                popupEmail.value = email;
                popup.style.display = 'block';
            });
        });

        closeBtn.onclick = function() {
            popup.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == popup) {
                popup.style.display = 'none';
            }
        }
    });
</script>
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