<?php
// fetch_members.php
header('Content-Type: application/json');
session_start();
include("society_dbE.php");

// Check if the user is logged in and has a valid society
if (!isset($_SESSION['m_society']) && !isset($_SESSION['a_society'])) {
    echo json_encode(['status' => 'error', 'message' => 'No society found in session.']);
    exit;
}

$society = $_SESSION['m_society'] ?? $_SESSION['a_society'];

try {
    // Fetch members associated with the society
    $stmt = $conn->prepare("SELECT m_name, flat_no FROM member_table WHERE society_reg = ?");
    $stmt->bind_param("s", $society);
    $stmt->execute();
    $result = $stmt->get_result();

    $members = [];
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }

    echo json_encode(['status' => 'success', 'data' => $members]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>