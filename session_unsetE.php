<?php

session_start();
if (isset($_SESSION["a_logged_in"])) {
	unset($_SESSION["a_id"]);
	unset($_SESSION["a_name"]);
	unset($_SESSION["a_society"]);
	unset($_SESSION["a_email"]);
	unset($_SESSION['a_logged_in']);
	unset($_SESSION['a_role']);

}

if (isset($_SESSION["m_logged_in"])) {
	$find = $_SESSION["m_society"] . "_";
	$mflat = str_replace($find, "", $_SESSION["m_flat"]);
	unset($_SESSION[$mflat]);
	unset($_SESSION["m_id"]);
	unset($_SESSION["m_name"]);
	unset($_SESSION["m_society"]);
	unset($_SESSION["m_email"]);
	unset($_SESSION['m_logged_in']);
	unset($_SESSION["m_flat"]);
	unset($_SESSION['m_role']);
}

if (isset($_SESSION["w_logged_in"])) {
	unset($_SESSION["w_id"]);
	unset($_SESSION["w_name"]);
	unset($_SESSION["w_society"]);
	unset($_SESSION["w_email"]);
	unset($_SESSION['w_logged_in']);
	unset($_SESSION['w_role']);
}
?>
<META HTTP-EQUIV="refresh" CONTENT="0; url =index.html">