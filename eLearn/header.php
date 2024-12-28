<?php
session_start();
?>

<style>
    .header_content {
    padding: 10px 0;
    }

    .logout-container {
    margin-left: auto; /* Pushes the logout button to the right */
    }

    .logout-container button {
    background: orange;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    width: 50px; /* Adjust size as needed */
    height: 50px; /* Adjust size as needed */
    transition: background-color 0.3s, color 0.3s;
    }

    .logout-container button:hover {
    background: black;
    }

    .logout-container button i {
    font-size: 24px;
    color: white;
    }

    .logo_container {
    margin-right: auto; /* Optional: If you want the logo to be on the left */
    }

    .learner-name {
            margin-right: 15px;
            font-size: 16px;
            font-weight: bold;
            color: #ff9800;
            padding: 5px 10px;
            border-radius: 5px;
        }

</style>
<header class="header">
    <!-- Header Content -->
    <div class="header_container">
        <div class="container">
            <div class="header_content d-flex flex-row align-items-center justify-content-between">
                <div class="logo_container">
                    <a href="#">
                        <div class="logo_content d-flex flex-row align-items-end justify-content-start">
                            <div class="logo_img"><img src="images/logo.png" alt=""></div>
                            <div class="logo_text">learn</div>
                        </div>
                    </a>
                </div>
                <div class="d-flex flex-row align-items-center">
                    <?php if (isset($_SESSION['name'])): ?>
                        <span class="learner-name"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                    <?php endif; ?>
                    <div class="logout-container d-flex flex-row align-items-center">
                        <button title="Logout" onclick="logout()"><i class="fa fa-power-off" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function logout() {
            if (confirm("Are you sure you want to logout?")) {
                // Perform logout actions
                window.location.href = 'php/logout.php';
            }
        }
    </script>
</header>
