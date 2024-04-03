<?php require_once ('../config.php') ?>
<?php
// Establish database connection
// Replace 'your_host', 'your_username', 'your_password', and 'your_database' with your actual database credentials
$conn = mysqli_connect('localhost', 'root', '', 'wbms_db',3306);

// Check if database connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve phone number and password from form
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];

    // Validate phone number and password
    // You should perform proper sanitization and validation here to prevent SQL injection
    // For simplicity, let's assume phone number and password are valid

    // Query to check if phone number exists in the database
    $query = "SELECT * FROM client_list WHERE contact = '$phone_number'";
    $result = mysqli_query($conn, $query);

    // Check if phone number exists in the database
    if (mysqli_num_rows($result) == 1) {
        // If phone number exists, fetch the corresponding row
        $row = mysqli_fetch_assoc($result);

        // Check if the password matches the static password ('123456')
        if ($password == '123456') {
            // If credentials match, redirect to home.php
            header("Location: clienthome.php");
            exit;
        }  else {
            // If password is incorrect, show error message
            $_SESSION['error_message'] = "Invalid password";
            header("Location: clientlogin.php");
            exit;
        }
    } else {
        // If phone number does not exist, show error message
        // $error_message = "Phone number not found";
        // error_log($error_message, 0);
        // echo $error_message;
        header("Location: error404.php");
    }

    // Close database connection
    mysqli_close($conn);
}
?>
