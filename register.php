<?php

if (isset($_POST['submit'])) {
        echo "<h2>Form Data Received:</h2>";
        echo "<strong>Username:</strong> " . $_POST['USERname'] . "<br>";
        echo "<strong>Email:</strong> " . $_POST['email'] . "<br>";
        echo "<strong>Date of Birth:</strong> " . $_POST['DOB'] . "<br>";
        echo "<strong>Gender:</strong> " . $_POST['gender'] . "<br>";
        echo "<strong>Country:</strong> " . $_POST['country'] . "<br>";
        echo "<strong>AQI:</strong> " . $_POST['AQI'] . "<br>";
        //echo "<strong>Password:</strong> " . $_POST['password'] . "<br>";
        echo "<strong>Background Color:</strong> " . $_POST['color'] . "<br>";
   
    }
 else {
    echo "No data submitted.";
}

?>
<!-- Button to go back to index.html -->
<form action="index.html" method="get" style="margin-top: 20px;">
    <input type="submit" value="Back to Home Page" />
</form>