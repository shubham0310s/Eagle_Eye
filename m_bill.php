<?php
include("society_dbE.php");
session_start();

if (isset($_SESSION["m_flat"])) {
    $society = $_SESSION["m_society"];
    $find = $society . "_";
    $flat = str_replace($find, "", $_SESSION["m_flat"]);

} else {
    $flat = "9999";
}
$result = mysqli_query($conn, "SELECT * FROM `visitor_table` WHERE `flat_no`='{$flat}' AND `status`='Approved' OR `flat_no`='{$flat}' AND `status`='Denied '");
if (isset($_SESSION['m_name']) && isset($_SESSION['m_email']) && isset($_SESSION['m_flat']) && isset($_SESSION['m_society'])) {
    $mname = $_SESSION['m_name'];
    $memail = $_SESSION['m_email'];
    $msociety = $_SESSION['m_society'];
    $mflat = $flat;
} else {
    $mname = "name";
    $memail = "Email@gmail.com";
    $msociety = "0000";
    $mflat = "A000";

}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Member Dashboard </title>
    <link rel="shortcut icon" href="img/2.png" type="image/png">
    <link rel="stylesheet" href="css\dashE.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <img src="./img/logo.png" alt="Eagle Eye Logo" style="width: 50px; height: auto;" />
            &emsp;&emsp;&emsp;
            <span class="logo_name">Eagle Eye</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="m_dashboardE.php">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">HOME</span>
                </a>
            </li>
            <li>
                <a href="" class="active">
                    <i class='bx bx-receipt' class="active"></i>
                    <span class="links_name">BILL</span>
                </a>
            </li>
            <li>
                <a href="m_event.php">
                    <i class='bx bx-calendar'></i>
                    <span class="links_name">EVENT</span>
                </a>
            </li>
            <li>
                <a href="m_chat.php">
                    <i class='bx bx-chat'></i>
                    <span class="links_name">CHAT</span>
                </a>
            </li>
            <li>
                <a href="m_requestE.php">
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">APPROVE/DENIED</span>
                    <?php
                    if (isset($_SESSION[$mflat])) {
                        $num = $_SESSION[$mflat];
                        if ($num) {
                            echo '<span class="material-icons">notifications</span>';
                            echo '<span class="icon-button__badge">' . $num . '</span>';
                        }
                    }
                    ?>
                </a>
            </li>
            <li>
                <a href="m_historyE.php">
                    <i class='bx bx-box'></i>
                    <span class="links_name">HISTORY</span>
                </a>
            </li>

            <li class="log_out">
                <a href="session_unsetE.php">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">BILL</span>
            </div>
            <!-- This start of account info function -->
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <link
                href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
                rel="stylesheet">
            </head>

            <body>
                <div class="action">
                    <div class="profile" onclick="menuToggle();">
                        <img src="images/host2.png" alt="">
                    </div>

                    <div class="menu">
                        <h3>
                            <?php
                            echo "<div id = 'eagleN'><b>" . $mname . "</b></div>";
                            echo "<div id = 'eagleR'>Member</div>";
                            echo "<div id = 'eagleN'>" . $memail . "</div>";
                            echo "<div id = 'eagleG'>" . $msociety . "</div>";
                            echo "<div id = 'eagleG'>" . $mflat . "</div>";
                            ?>
                        </h3>
                        <ul>
                            <li>
                                <span class="material-icons icons-size">mode</span>
                                <a href="change_passE.php">Edit Password</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <script>
                    function menuToggle() {
                        const toggleMenu = document.querySelector('.menu');
                        toggleMenu.classList.toggle('active')
                    }
                </script>
                <!-- This end of account info function -->
        </nav>

        <div class="home-content">
            <div class="overview-boxes">
                <div class="box">
                    <a href="javascript:void(0)" id="maintenance-btn">
                        <div class="right-side">
                            <div class="box-topic"></div>
                            <div class="number">Maintenance</div>
                        </div>
                    </a>
                </div>
                <div class="box">
                    <a href="">
                        <div class="right-side">
                            <div class="box-topic"></div>
                            <div class="number">Rent Payment</div>

                        </div>

                    </a>
                </div>
                <div class="box">
                    <a href="">
                        <div class="right-side">
                            <div class="box-topic"></div>
                            <div class="number">Meter Reading</div>
                        </div>
                    </a>
                </div>

                <div class="box">
                    <a href="">
                        <div class="right-side">
                            <div class="box-topic"></div>
                            <div class="number">Pay Maid/Cook</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div id="popup"
            style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); z-index: 1000; width: 300px; padding: 20px; text-align: center;">
            <h2 style="margin-bottom: 20px;">Pay Maintenance</h2>
            <form action="process_payment.php" method="POST">
                <input type="text" name="amount" placeholder="Enter Amount"
                    style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;"
                    required>
                <button type="submit"
                    style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">Pay</button>
                <button type="button" id="close-btn"
                    style="padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">Close</button>
            </form>
        </div>
        <div id="overlay"
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;">
        </div>

        <script>
            // JavaScript for Popup
            document.getElementById('maintenance-btn').addEventListener('click', function () {
                document.getElementById('popup').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';
            });

            document.getElementById('close-btn').addEventListener('click', function () {
                document.getElementById('popup').style.display = 'none';
                document.getElementById('overlay').style.display = 'none';
            });

            document.getElementById('overlay').addEventListener('click', function () {
                document.getElementById('popup').style.display = 'none';
                document.getElementById('overlay').style.display = 'none';
            });
        </script>
    </section>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function () {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    </script>

</body>

</html>