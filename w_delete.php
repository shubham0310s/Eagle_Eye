<?php
session_start();
if (!isset($_SESSION['a_logged_in'])) {
    header("Location: index.html");
    exit;
}
include("society_dbE.php");
if (isset($_POST["wdelete"])) {
    $wid = $_POST["wdelete"];
    $wresult = mysqli_query($conn, "DELETE FROM `watchman_tabe` WHERE `watchman_id`='{$wid}'");
    if ($wresult) {
        echo "<script> alert('Record deleted successfully ')</script>";
        ?>
        <META HTTP-EQUIV="refresh" CONTENT="0; url = a_dashboardE.php">
        <?php
    } else
        echo "Error deleting record ";

}

?>