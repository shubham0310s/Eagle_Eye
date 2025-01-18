<?php
require("society_dbE.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $_SESSION['m_society'] = $society;  // Set the society registration number
    $_SESSION['flat_no'] = $flat_no;    // Set the flat numberke sure `flat_no` is stored in the session during login

    // Ensure that flat_no and society are set
    if (empty($flat_no) || empty($society)) {
        echo "<script>alert('Error: Missing society or flat number information.'); window.location.href = 'm_bill.php';</script>";
        exit;
    }

    // Validate amount input
    if (!empty($amount) && is_numeric($amount)) {
        // Check if the flat_no exists in member_table
        $checkQuery = "SELECT * FROM member_table WHERE flat_no = '$flat_no' AND society_reg = '$society'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            // Insert payment details into the database
            $query = "INSERT INTO `payments` (`society_reg`, `flat_no`, `amount`, `status`) VALUES ('{$society}', '{$flat_no}', '{$amount}', 'Pending')";

            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Payment recorded successfully!'); window.location.href = 'm_bill.php';</script>";
            } else {
                echo "<script>alert('Error processing payment: " . mysqli_error($conn) . "'); window.location.href = 'm_bill.php';</script>";
            }
        } else {
            echo "<script>alert('Flat number or society does not exist in the database.'); window.location.href = 'm_bill.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid amount entered.'); window.location.href = 'm_bill.php';</script>";
    }
}
?>