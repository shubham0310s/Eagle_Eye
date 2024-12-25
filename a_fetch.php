<?php
include("society_dbE.php");
session_start();

// Ensure the user is logged in as admin
if (!isset($_SESSION['a_logged_in'])) {
	header("Location: index.html");
	exit;
}

// Determine the society based on the session
if (isset($_SESSION["a_society"])) {
	$society = $_SESSION["a_society"];
	$find = $society . "_";
} else {
	$society = 0000;
}

$output = '';

// Search functionality
if (isset($_POST["query"])) {
	$search = mysqli_real_escape_string($conn, $_POST["query"]);
	$query = "
    SELECT * FROM `watchman_table` WHERE `society_reg`='{$society}' AND 
    (`w_name` LIKE '%" . $search . "%' 
    OR `w_email` LIKE '%" . $search . "%')";

	$result = mysqli_query($conn, $query);
}

if (isset($result)) {
	if (mysqli_num_rows($result) > 0) {
		$output .= '<div style="width: 1000px; background-color: blanchedalmond; margin-left: -169px;">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>';
		while ($row = mysqli_fetch_array($result)) {
			$output .= '
            <tr>
                <td>' . htmlspecialchars($row["w_name"]) . '</td>
                <td>' . htmlspecialchars($row["w_email"]) . '</td>
            </tr>';
		}
		echo $output;
	} else {
		echo 'Data Not Found';
	}
} else {
	// Display empty table if no result is found or query is not set
	$output .= '<div style="width: 1193px; background-color: blanchedalmond; margin-left: -173px;">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>';
	echo $output;
}
?>