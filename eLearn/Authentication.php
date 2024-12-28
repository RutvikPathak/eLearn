<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration and Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            background-image: url('images/registration_background.jpg');
            background-size: cover;
            background-position: center;
        }
        .container {
            width: 30%;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #ffa500;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #ff8c00;
        }
        .switch-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
        .switch-btn a {
            color: #ffa500;
            text-decoration: none;
        }
        .switch-btn a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container" id="register-box">
    <h2>Registration</h2>
    <form action="php/registration.php" method="post" onsubmit="return validateForm()">
        <input type="text" name="learner_name" placeholder="Enter your Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="submit" value="Sign Up">
    </form>
    <p class="switch-btn">Already have an account? <a href="#" onclick="showLogin()">Log in here</a></p>
</div>

<div class="container" id="login-box" style="display:none;">
    <h2>Login</h2>
    <form action="php/login.php" method="post">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <p class="switch-btn">Forgot password? <a href="#" onclick="showForgotPassword()">Click here</a><br><br>
    New here? <a href="#" onclick="showRegister()">Register now</a></p>
</div>


<div class="container" id="forgot-box" style="display:none;">
    <h2>Forgot Password</h2>
    <form action="php/forgot_password.php" method="post">
        <input type="email" name="email" placeholder="Enter your Email Address" required>
        <input type="submit" value="Reset Password">
    </form>
    <p class="switch-btn">Remembered your password? <a href="#" onclick="showLogin()">Log in here</a></p>
</div>


<script>
        function showLogin() {
        document.getElementById("register-box").style.display = "none";
        document.getElementById("login-box").style.display = "block";
        document.getElementById("forgot-box").style.display = "none";
    }

    function showRegister() {
        document.getElementById("login-box").style.display = "none";
        document.getElementById("register-box").style.display = "block";
        document.getElementById("forgot-box").style.display = "none";
    }

    function showForgotPassword() {
        document.getElementById("login-box").style.display = "none";
        document.getElementById("register-box").style.display = "none";
        document.getElementById("forgot-box").style.display = "block";
    }

    function validateForm() {
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;

        if (password != confirm_password) {
            alert("Passwords do not match");
            return false;
        }
        return true;
    }

    // Check if registered or duplicate query parameter is present to show appropriate messages
    const urlParams = new URLSearchParams(window.location.search);
    const registered = urlParams.get('registered');
    const duplicate = urlParams.get('duplicate');

    if (registered) {
        alert("Registration successful!");
        showLogin(); // Display the login box after registration
    } else if (duplicate) {
        alert("Email address is already registered.");
    }

</script>

</body>
</html>
