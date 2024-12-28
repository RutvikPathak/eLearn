<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: authentication.php');
    exit();
}

require_once('php/db.php'); // Adjust the path as per your file structure

// Fetch learner's name based on email
$email = $_SESSION['email'];
$sql = "SELECT L_Name FROM learner WHERE L_Email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $learner_name = $row['L_Name'];
} else {
    // Handle case where user not found
    $learner_name = 'Learner';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Contact</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Elearn project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="plugins/video-js/video-js.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="styles/contact.css">
<link rel="stylesheet" type="text/css" href="styles/contact_responsive.css">
</head>
<body>

<div class="super_container">

	<!-- Header -->
	<?php include 'header.php'; ?>


	
	<!-- Home -->

	<div class="home">
		<!-- Background image artist https://unsplash.com/@thepootphotographer -->
		<div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/contact.jpg" data-speed="0.8"></div>
		<div class="home_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content text-center">
							<div class="home_title">Contact</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Contact -->

	<div class="contact">
		<div class="container-fluid">
			<div class="row row-xl-eq-height" style="margin-left: 7%;">
				<!-- Contact Content -->
				<div class="col-xl-6">
					<div class="contact_content">
						<div class="row">
							<div class="col-xl-6">
								<div class="contact_about">
									<div class="logo_container">
										<a href="#">
											<div class="logo_content d-flex flex-row align-items-end justify-content-start">
												<div class="logo_img"><img src="images/logo.png" alt=""></div>
												<div class="logo_text">learn</div>
											</div>
										</a>
									</div>
									<div class="contact_about_text">
										<p style="text-align: justify;">I value your feedback and inquiries. Whether you have a question about my services, need assistance, 
											or simply want to share your thoughts, I am here to help. Please reach out to me using the form below or email at 
											<a href="mailto:rutvikpathak2000@gmail.com" style="text-decoration: none; color: orange;" onmouseover="this.style.color='black'" onmouseout="this.style.color='orange'">rutvikpathak2000@gmail.com</a>
											. We strive to respond to all messages promptly and look forward to connecting with you.</p>
									</div>
								</div>
							</div>
							<div class="col-xl-6">
								<div class="contact_info_container">
									<div class="contact_info_main_title">Contact Us</div>
									<div class="contact_info">
										<div class="contact_info_item">
											<div class="contact_info_title">Address:</div>
											<div class="contact_info_line">23 Nahanni Terrace, Toronto, ON - M1B 1B7</div>
										</div>
										<div class="contact_info_item">
											<div class="contact_info_title">Phone:</div>
											<div class="contact_info_line">+1(519)572-2515</div>
										</div>
										<div class="contact_info_item">
											<div class="contact_info_title">Email:</div>
											<div class="contact_info_line">rutvikpathak2000@gmail.com</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="contact_form_container">
							<form action="#" id="contact_form" class="contact_form">
								
									
								<div><input type="text" class="contact_input" placeholder="Name" required="required" name="name" value="<?php echo htmlspecialchars($learner_name); ?>"></div>
								<div><input type="email" class="contact_input" placeholder="E-mail" required="required" name="email" value="<?php echo htmlspecialchars($email); ?>"></div>
								<div><input type="text" class="contact_input" placeholder="Subject" required="required" name="subject"></div>
								<div><textarea class="contact_input contact_textarea" placeholder="Message" name="message"></textarea></div>
								<div class="sent-message" style="display: none;">Your message has been sent. Thank you!</div>
								<button class="contact_button"><span>send message</span><span class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
							</form>
						</div>

							<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
							<script type="text/javascript">
							(function() {
								emailjs.init("vsvt9BKKNmtqq5xL7"); // Replace with your actual EmailJS public key
							})();

							document.getElementById('contact_form').addEventListener('submit', function(event) {
								event.preventDefault();

								// Send email
								emailjs.sendForm('service_57mpc8f', 'template_bhsjw6q', this)
									.then(function(response) {
										console.log('SUCCESS!', response.status, response.text);
										document.querySelector('.sent-message').style.display = 'block';
										clearForm();
									}, function(error) {
										console.log('FAILED...', error);
										alert('Sorry, there was an error sending your message. Please try again later.');
									});
							});

							function clearForm() {
								document.getElementById('subject').value = '';
								document.getElementById('message').value = '';
							}
                            </script>
					</div>
				</div>

				<!-- Contact Map -->
				<div class="col-xl-6 map_col">
					<div class="contact_map">

						<!-- Google Map -->
						<div id="google_map" class="google_map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2879.6429685743196!2d-79.22681032513893!3d43.801021042859645!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d4d0c73eb90fe5%3A0x1b575782a7a55848!2s23%20Nahanni%20Terrace%2C%20Scarborough%2C%20ON%20M1B%201B7!5e0!3m2!1sen!2sca!4v1718170001208!5m2!1sen!2sca" width="700" height="1200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
						</div>

					</div>
				</div>
			</div>
				
		</div>
	</div>

	<!-- Footer -->
	<?php include 'footer.php'; ?>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
<script src="js/contact.js"></script>
</body>
</html>