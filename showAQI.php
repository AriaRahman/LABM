<?php
session_start();

// Store selected cities in session if form was submitted
if (isset($_POST['submit']) && isset($_POST['cities']) && count($_POST['cities']) === 10) {
    $_SESSION['selected_cities'] = $_POST['cities'];
} elseif (!isset($_SESSION['selected_cities'])) {
    echo "No cities selected.";
    exit;
}

// Get cities from session
$cities = $_SESSION['selected_cities'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "AQI");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dynamically build placeholders and prepare the query
$placeholders = implode(',', array_fill(0, count($cities), '?'));
$query = "SELECT city, country, aqi FROM info WHERE city IN ($placeholders)";
$stmt = $conn->prepare($query);

// Bind parameters
$types = str_repeat('s', count($cities));
$stmt->bind_param($types, ...$cities);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>AQI Results</title>
    <style>
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            text-align: center;
        }
        th, td {
            border: 2px solid #333;
            padding: 10px;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Air Quality Index (AQI) for Selected Cities</h2>
    <table>
        <thead>
            <tr>
                <th>City</th>
                <th>Country</th>
                <th>AQI</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['city']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['country']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['aqi']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No data found for the selected cities.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
<!-- Button to go back to index.html -->
<form action="index.html" method="get" style="margin-top: 20px;">
    <input type="submit" value="Back to Home Page" onclick="backbutton()"/>
</form>

<script>
    function backbutton()
    {
            header("refresh: 2; url = index.html");


    }
    </script>

