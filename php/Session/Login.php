<?php
    session_start(); // Starting Session
    $error=''; // Variable To Store Error Message
    
    if (isset($_POST['submit'])) 
    {
        if (empty($_POST['username']) || empty($_POST['password']))
        {
            $error = " Invalid Password or Username ";
        }
        else
        {
            if(!@include_once('./php/Session/ConnectServer.php'))
                $error = " Error while connecting... ";
               
            // Define variables
            $username = $_POST['username'];
            $password = $_POST['password'];
            $tip_tabel = $_POST['tip_tabel'];
            
            // To protect MySQL injection for Security purpose
            $username = stripslashes($username);
            
            // SQL query to fetch information of registerd users and finds user match.
            $sql = "SELECT username, password FROM Users";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0)
            { 
                while ($db_field = $result->fetch_assoc()) 
                {
                    if (password_verify($password, $db_field["password"]) && $username == $db_field["username"])
                    {
                        $_SESSION['login_user'] = $username; // Initializing Session
                        
                        // --------- redirect to the right page ---------
                        if ($username != "admin")
                            header('Location: ./php/Session/Users/UserPage.php?type=' . $tip_tabel);
                        else header('Location: ./php/Session/Admin/AdminPage.php');
                    }
                    else $error = " Invalid Password or Username ";
                }
            } 
            else 
            {
                $error = " Invalid Password or Username ";
            }
                
            $conn->close(); // Closing Connection
        }
    }
?>