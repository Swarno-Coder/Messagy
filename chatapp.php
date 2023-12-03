<!DOCTYPE html>
<html>
    <head>
        <title>Chat App</title>
    <link rel="stylesheet" href="./app.css">
    <link rel="shortcut icon" href="./chatico.jpg" type="image/x-icon">
</head>
<body class="chat">
    <div class="chat-container">
        <h2 class="user-header">
            <?php
            // Display the username of the logged in user
            session_start();
            echo $_SESSION["reciever"];
            ?>
        </h2>
        <div id="chat-messages">
            <?php
            // Fetch and display messages from the database
            
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
            if(isset($_POST["send"])) {
                $msg = $_POST["msg"];
                $sender = $_SESSION["username"];
                $reciever = $_SESSION["reciever"];
                $time = date("Y-m-d H:i:s");

                $sql = "INSERT INTO message (sender, reciever, time, msg) VALUES ('$sender', '$reciever', '$time','$msg')";
                $conn->query($sql);
                $conn -> query("commit");
            }

            $sql = "SELECT * FROM message WHERE (sender = '" . $_SESSION['username'] . "' AND reciever = '" . $_SESSION['reciever'] . "') OR (sender = '" . $_SESSION['reciever'] . "' AND reciever = '" . $_SESSION['username'] . "') ORDER BY time ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="message">';
                    if ($row["sender"] == $_SESSION["username"]) {
                        echo '<div class="msg-right">';
                        echo '<span>' . $row["msg"]. ': </span>';
                        echo '<span class="timestamp">' . $row["time"] . '</span>';
                        echo '</div>';
                    } else {
                        echo '<div class="msg-left">';
                        echo '<span>' . $row["msg"] . ': </span>';
                        echo '<span class="timestamp">' . $row["time"] . '</span>';
                        echo '</div>';
                    }                  
                    echo '</div>';
                }
            } else {
                echo "No messages found.<br>Send a message to start a conversation.";
            }
            
            $conn->close();
            session_abort();
            ?>
        </div>
        <form id="message-form" action="" method="POST">
            <input type="text"  name="msg" placeholder="Type your message..." required>
            <button type="submit" name="send">Send</button>
        </form>
    </div>
</body>
</html>

