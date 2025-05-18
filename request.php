<?php
session_start(); // Start the session

// DB connection
$conn = new mysqli("localhost", "root", "", "AQI");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cities from INFO table
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
    <h2>Select 10 cities to view AQI</h2>

    <form method="post" action="showaqi.php" onsubmit="return validateCheckboxLimit()">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $city = htmlspecialchars($row['city']);
                echo "<label><input type='checkbox' name='cities[]' value='$city'> $city</label>";
            }
        } else {
            echo "No cities found in the database.";
        }
        $conn->close();
        ?>
        <br>
        <input type="submit" name="submit" value="Show AQI">
    </form>

    <script>
    function validateCheckboxLimit() {
        const checkboxes = document.querySelectorAll("input[name='cities[]']:checked");
        if (checkboxes.length==10) {
            alert("Please select 10 cities.");
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
