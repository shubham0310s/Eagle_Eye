<?php
include("society_dbE.php");
session_start();

// Ensure the user is logged in as either watchman or admin
if (!isset($_SESSION['w_logged_in']) && !isset($_SESSION['a_logged_in'])) {
    header("Location: index.html");
    exit;
}

// Determine the society based on the session
if (isset($_SESSION["w_society"])) {
    $society = $_SESSION["w_society"];
    $find = $society . "_";
} elseif (isset($_SESSION["a_society"])) {
    $society = $_SESSION["a_society"];
    $find = $society . "_";
} else {
    $society = "0000";
}

$output = '';

// Search functionality
if (isset($_POST["query"])) {
    $search = mysqli_real_escape_string($conn, $_POST["query"]);
    $query = "SELECT * FROM `member_table` WHERE `society_reg`='{$society}' AND  
    (`m_name` LIKE '%" . $search . "%'
    OR `residence` LIKE '%" . $search . "%' 
    OR `flat_no` LIKE '%" . $search . "%'
    OR `m_email` LIKE '%" . $search . "%')";
    $result = mysqli_query($conn, $query);
} else {
    $query = "";
}

if (isset($result)) {
    if (mysqli_num_rows($result) > 0) {
        $output .= '<div style="width: 1111px; background-color:rgba(8, 29, 69, 0.25); margin-left: -169px;">
                    </style>
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <th>Residence</th>
                            <th>Phone Number</th>
                            <th>Flat Number</th>
                            <th>Email</th>
                            <th>Payment</th>
                        </tr>';
        while ($row = mysqli_fetch_array($result)) {
            // Remove the society prefix from flat_no
            $flat = str_replace($find, "", $row["flat_no"]);
            $output .= '
                <tr>
                    <td>' . htmlspecialchars($row["m_name"]) . '</td>
                    <td>' . htmlspecialchars($row["residence"]) . '</td>
                    <td>' . htmlspecialchars($row["phone_no"]) . '</td>
                    <td>' . htmlspecialchars($flat) . '</td>
                    <td class="email-column">' . htmlspecialchars($row["m_email"]) . '</td>
                    <td>' . htmlspecialchars($row["payment_status"]) . '</td>
                </tr>
            ';
        }
        echo $output;
    } else {
        echo 'Data Not Found';
    }
} else {
    $output .= '<div style="width: 1193px; background-color: blanchedalmond; margin-left: -173px;">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Residence</th>
                        <th>Phone Number</th>
                        <th>Flat Number</th>
                        <th>Email</th>
                        <th>Payment</th>
                    </tr>';
    echo $output;
}
?>