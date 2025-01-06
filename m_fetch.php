<?php
include("society_dbE.php");
session_start();
if (!isset($_SESSION['m_logged_in'])) {
	header("Location: index.html");
	exit;
}
if (isset($_SESSION["m_flat"]) && isset($_SESSION['m_society'])) {
	$flat = $_SESSION["m_flat"];
	$find = $_SESSION['m_society'] . "_";
	$flat = str_replace($find, "", $_SESSION["m_flat"]);
} else {

	$flat = 0000;
}
$output = '';
if (isset($_POST["query"])) {	//var_dump($flat);
	$search = mysqli_real_escape_string($conn, $_POST["query"]);
	$query = "
	SELECT * FROM visitor_table
	WHERE flat_no = '{$flat}' AND  v_name LIKE '%" . $search . "%'
	OR flat_no = '{$flat}' AND phone_no LIKE '%" . $search . "%'
	OR flat_no = '{$flat}' AND status LIKE '%" . $search . "%' ";

	$result = mysqli_query($conn, $query);
}


if (isset($result)) {
	if (mysqli_num_rows($result) > 0) {
		$output .= '<div style="width: 1193px;
		background-color: blanchedalmond;
		margin-left: -173px;">
						<table class="table table bordered">
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Phone_no</th>
								<th>Visiting date </th>
								<th>Visiting purpose</th>
								<th>Status</th>
							</tr>';
		while ($row = mysqli_fetch_array($result)) {
			$output .= '
				<tr>
					<td>' . $row["visitor_id"] . '</td>
					<td>' . $row["v_name"] . '</td>
					<td>' . $row["phone_no"] . '</td>
					<td>' . $row["visiting_date"] . '</td>
					<td>' . $row["visiting_purpose"] . '</td>
					<td>' . $row["status"] . '</td>
				</tr>
			';
		}
		echo $output;
	} else {
		echo 'Data Not Found';
	}
} else {
	$output .= '<div style="width: 1193px;
		background-color: blanchedalmond;
		margin-left: -173px;">
						<table class="table table bordered">
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Phone_no</th>
								<th>Visiting date </th>
								<th>Visiting purpose</th>
								<th>Status</th>
							</tr>';
	echo $output;
}
?>