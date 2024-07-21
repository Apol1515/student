<?php

require 'connection.php'; // Include your database connection script

// Set default student_id
$default_student_id = '1000'; // Change this to the default student ID you want

// Check if student_id is provided in the query string, otherwise use default
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : $default_student_id;

// Prepare the SQL query to fetch student details
$stmt = $conn->prepare("SELECT student_id, department, violation_type FROM students WHERE student_id = ?");
$stmt->bind_param("s", $student_id);

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Check if the student exists
if ($result->num_rows > 0) {
    // Fetch the student details
    $profile = $result->fetch_assoc();
    // Return the profile data as JSON
    echo json_encode($profile);
} else {
    // No student found, return an error message
    echo json_encode(['error' => 'Student not found']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>