<?php
include("society_dbE.php"); // Include the database connection file

// Check if the society session is set
if (isset($_SESSION["a_society"])) {
    $society = $_SESSION["a_society"];
} else {
    $society = "0000"; // Default society if not set
}

// Fetch events from the events table for the specific society
$query = "SELECT * FROM events WHERE society_reg = '{$society}'";
$result = mysqli_query($conn, $query);

// Prepare the events array to hold events in FullCalendar's format
$events = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = [
            'title' => $row['event_title'], // Event title
            'start' => $row['event_start'], // Event start date/time
            'end' => $row['event_end'],     // Event end date/time
            'description' => $row['event_description'], // Optional description
            'location' => $row['event_location'], // Optional location
            'id' => $row['event_id'], // Event ID (for editing or deleting purposes)
            // Add any other custom fields as needed
        ];
    }
} else {
    // Handle query error
    $events[] = [
        'title' => 'Error fetching events',
        'start' => date('Y-m-d H:i:s'),
        'end' => date('Y-m-d H:i:s'),
        'description' => 'An error occurred while fetching events.',
    ];
}

// Return the events array as a JSON response
echo json_encode($events);
?>