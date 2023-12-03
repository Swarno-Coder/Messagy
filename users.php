<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./app.css">
</head>
<body class="user">
    <div class="header">
        <img src="./chatico.jpg" alt="chatapp" width="50px" height="50px"/>
        <h1>Messagy</h1>
    </div>
    <form action="" method="post">
    <?php
    // Assuming you have a database connection established
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Query to fetch usernames with connection or chat history
    $query = "SELECT username from users where username != '" . $_SESSION['username'] . "'";
    
    // Execute the query and fetch the results
    $result = mysqli_query($conn, $query);
    
    // Display the usernames
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<input class='usernamebox' name='reciever' type='submit' value='".$row['username']. "'/>";
    }

    if(isset($_POST["reciever"])) {
        $_SESSION["reciever"] = $_POST["reciever"];
        echo "<script>window.open('./chatapp.php', 'chats');</script>";
    }

    ?>
    </form>
</body>
</html>