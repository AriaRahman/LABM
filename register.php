<?php
session_start();

if (isset($_POST['submit'])) {
    // Store session variables (except color)
    $_SESSION['username'] = $_POST['USERname'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['dob'] = $_POST['DOB'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['country'] = $_POST['country'];
    $_SESSION['aqi'] = $_POST['AQI'];
    //$_SESSION['password'] = $_POST['password'];
    // Save background color in a cookie (expires in 1 hour)
    setcookie("bgcolor", $_POST['color'], time() + 3600, "/");

    // Store password securely
   $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Database connection
    $conn = new mysqli("localhost", "root", "", "AQI");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into users table
    $stmt = $conn->prepare("INSERT INTO users (username, email, dob, gender, country, aqi, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $_POST['USERname'], $_POST['email'], $_POST['DOB'], $_POST['gender'], $_POST['country'], $_POST['AQI'], $hashedPassword);
    
    if ($stmt->execute()) {
        echo "<h2>Registration Successful!</h2>";

        // ✅ Show the submitted data in a table
        echo "<table border='1' cellpadding='10' style='margin-top: 20px'>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        echo "<tr><td>Username</td><td>" . $_POST['USERname'] . "</td></tr>";
        echo "<tr><td>Email</td><td>" . $_POST['email'] . "</td></tr>";
        echo "<tr><td>Date of Birth</td><td>" . $_POST['DOB'] . "</td></tr>";
        echo "<tr><td>Gender</td><td>" . $_POST['gender'] . "</td></tr>";
        echo "<tr><td>Country</td><td>" . $_POST['country'] . "</td></tr>";
        echo "<tr><td>AQI opinion</td><td>" . $_POST['AQI'] . "</td></tr>";
        echo "<tr><td>Background Color (Cookie)</td><td>" . $_POST['color'] . "</td></tr>";
        echo "</table>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Back to Home Button -->
<form action="index.html" method="get" style="margin-top: 20px;">
    <input type="submit" value="Back to Home Page" />
</form>
