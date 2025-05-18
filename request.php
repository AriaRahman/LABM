<?php
session_start(); // Start the session

// Connect to the database
$conn = new mysqli("localhost", "root", "", "AQI");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch unique cities from INFO table
$sql = "SELECT DISTINCT city FROM info ORDER BY city";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select Cities</title>
    <style>
        label { display: block; margin: 5px 0; }
    </style>
</head>
<body>
    <h2>Select 10 Cities to View AQI</h2>

    <form method="post" action="showaqi.php">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $city = htmlspecialchars($row['city']);
                echo "<label><input type='checkbox' name='cities[]' value='{$city}'> {$city}</label>";
            }
        } else {
            echo "<p>No cities found in the database.</p>";
        }
        $conn->close();
        ?>
        <br>
        <input type="submit" name="submit" value="Show AQI" onclick="return validateCheckboxLimit();">
    </form>

    <script>
    function validateCheckboxLimit() {
        const selected = document.querySelectorAll("input[name='cities[]']:checked");
        if (selected.length !== 10) {
            alert("Please select exactly 10 cities.");
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
