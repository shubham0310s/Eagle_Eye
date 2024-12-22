<?php
require_once("society_dbE.php");
session_start();
if (!isset($_SESSION['a_logged_in'])) {
    header("Location: index.html");
    exit;
}

$success = "";
$error_msg = "";
if (isset($_POST['wupdate'])) {
    $id = $_POST['wupdate'];
    $sql = mysqli_query($conn, "SELECT * FROM `watchman_tabe` WHERE `watchman_id`='{$id}'");
    if ($sql) {
        $watchman = mysqli_fetch_array($sql);
    }
}
if (isset($_POST['update'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $wid = mysqli_real_escape_string($conn, $_POST['watch_id']);

    if (isset($_FILES['file'])) {
        //storing all necessary data into the respective variables.
        $file = $_FILES['file'];
        $file_name = $file['name'];
        $file_type = $file['type'];
        $file_size = $file['size'];
        $file_path = $file['tmp_name'];

        if (($file_type = "image/jpeg" || $file_type = "image/png") && $file_size <= 41943040) {
            // create and format some variables for the database
            $update = mysqli_query($conn, "UPDATE `watchman_tabe` SET `w_name`='{$name}',`w_email`='{$email}',`w_docs`='{$file_name}' WHERE `watchman_id`='{$wid}'");
            move_uploaded_file($file_path, 'watch_docs/' . $file_name);

            if ($update)
                $success = true;
        }
    } else {
        $update = mysqli_query($conn, "UPDATE `watchman_tabe` SET `w_name`='{$name}',`w_email`='{$email}' WHERE `watchman_id`='{$wid}'");

        if ($update)
            $success = true;
    }

}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Update</title>
    <link rel="shortcut icon" href="img/2.png" type="image/png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="css/registerE.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

    </script>
</head>

<body>
    <div class="register">
        <h1>Watchman Detail</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off"
            enctype="multipart/form-data">

            <label for="watch_id">
                <i class="fas fa-bomb"></i>
            </label>
            <input type="text" name="watch_id" value="<?php if (isset($watchman))
                echo "$watchman[watchman_id]"; ?>" placeholder="ID" id="watch_id" readonly>


            <label for="name">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="name" value="<?php if (isset($watchman))
                echo "$watchman[w_name]"; ?>" placeholder="Name" id="name" required>

            <script>$(document).ready(function () {
                    $("#name").on("blur", function () {
                        if (!$(this).val().match(/^[a-zA-Z]+$/)) {
                            alert("Please enter a valid name");
                        }
                    });
                });
            </script>


            <label for="email">
                <i class="fas fa-envelope"></i>
            </label>
            <input type="email" name="email" value="<?php if (isset($watchman))
                echo "$watchman[w_email]"; ?>" placeholder="Email" id="email" required>

            <script>$(document).ready(function () {
                    $("#email").on("blur", function () {
                        if (!$(this).val().match(/^.+@gmail\.com$/)) {
                            alert("Please enter a valid email address");
                        }
                    });
                });
            </script>

            <!-- <label for="document ">
                <i class="fa fa-home"></i>
            </label>
            
            <div class="file-upload-wrapper" data-text=" Documents ">
                   <input type="file" name="file" id="file">
              </div> -->
            <?php
            // check to see if the user successfully created an account
            if (isset($success) && $success == true) {
                echo '<script>
                      alert("Update Successfull");
                      // Load a new URL in the current window
                      window.location.assign(" a_dashboardE.php");
                  </script>';
            }
            if (isset($error_msg)) {
                echo "<p>" . $error_msg . "</p>";
            }
            ?>

            <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>

</html>