<?php
include("society_dbE.php");
session_start();
if (!isset($_SESSION['w_logged_in']) && !isset($_SESSION['a_logged_in'])) {
	header("Location: index.html");
	exit;
}
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
if (isset($_POST["query"])) {
	$search = mysqli_real_escape_string($conn, $_POST["query"]);
	$query = "
	SELECT * FROM `member_table` WHERE `society_reg`='{$society}' AND  
	`m_name`LIKE '%" . $search . "%'
	OR `society_reg`='{$society}' AND `residence` LIKE '%" . $search . "%' 
	OR `society_reg`='{$society}' AND `flat_no` LIKE '%" . $search . "%'
	OR `society_reg`='{$society}' AND  `m_email` LIKE '%" . $search . "%'";

	$result = mysqli_query($conn, $query);
} else {
	$query = "";
}

if (isset($result)) {
	if (mysqli_num_rows($result) > 0) {
		$output .= '<div style="width: 1193px;
		background-color: blanchedalmond;
		margin-left: -173px;">
						<table class="table table bordered">
							<tr>
								
								<th>Name</th>
								<th>Residence</th>
								<th>phone_no</th>
								<th>Flat_no</th>
								<th>E-mail</th>
							</tr>';
		while ($row = mysqli_fetch_array($result)) {
			$flat = str_replace($find, "", $row["flat_no"]);
			$output .= '
				<tr>
			
					<td>' . $row["m_name"] . '</td>
					<td>' . $row["residence"] . '</td>
					<td>' . $row["phone_no"] . '</td>
					<td>' . $flat . '</td>
					<td>' . $row["m_email"] . '</td>
					
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
								
							<th>Name</th>
							<th>Residence</th>
							<th>phone_no</th>
							<th>Flat_no</th>
							<th>E-mail</th>
						</tr>';

	echo $output;
}
?>