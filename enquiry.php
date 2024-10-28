<?php
// Database configuration
$servername = "localhost"; // Change as needed
$username = "your_username"; // Change as needed
$password = "your_password"; // Change as needed
$dbname = "your_database"; // Change as needed

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = htmlspecialchars(trim($_POST['name']));
    $company = htmlspecialchars(trim($_POST['company']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $country = htmlspecialchars(trim($_POST['country']));
    $industry = htmlspecialchars(trim($_POST['industry']));
    $remarks = htmlspecialchars(trim($_POST['remarks']));

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email)) {
        echo "Please fill in all required fields.";
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO enquiries (name, company, phone, email, country, industry, remarks) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $company, $phone, $email, $country, $industry, $remarks);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Thank you for your enquiry. We will get back to you soon.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // If the form is not submitted, redirect or show an error
    header("Location: your-form-page.php"); // Change this to the page with your form
    exit;
}

// Close the connection
$conn->close();
?>