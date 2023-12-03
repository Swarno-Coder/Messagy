<?php
$conn = mysqli_connect("localhost", "root", "", "test");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["login"])) 
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Connect to the MySQL database

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement to fetch the user with the given username and password
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Start a session
        session_start();

        // Store the username in the session
        $_SESSION["username"] = $username;

        // Redirect to another PHP webpage
        header("Location: ./chatappidx.html");
        exit();
    } else {
        // Invalid credentials
        echo "Invalid username or password";
    }
} 
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["signup"]))
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement to insert the new user into the users table
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    $result = mysqli_query($conn, $sql);

    // Check if the insertion was successful
    if ($result) {
        // Redirect to the login page
        header("Location: ./index.html");
        exit();
    } else {
        // Error occurred while inserting the user
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
