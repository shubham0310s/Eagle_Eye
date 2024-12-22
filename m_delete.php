<?php
session_start();
if (!isset($_SESSION['a_logged_in'])) {
  header("Location: index.html");
  exit;
}
if (!isset($_SESSION['m_logged_in'])) {
  header("Location: index.html");
  exit;
}
if (!isset($_SESSION['w_logged_in'])) {
  header("Location: index.html");
  exit;
}
include("society_dbE.php");
if (isset($_POST["mdelete"])) {
  $mid = $_POST["mdelete"];
  $mresult = mysqli_query($conn, "DELETE FROM `member_table` WHERE `member_id`='{$mid}'");
  if (isset($mresult)) {
    echo "<script> alert('Record deleted successfully ')</script>";
    ?>
    <META HTTP-EQUIV="refresh" CONTENT="0; url = a_dashboardE.php">
    <?php
  } else
    echo "Error deleting record ";

}

?>