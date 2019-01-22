
<!--This page contains all html and php code for the login of the users
    All of the vaidations will be done in the this same page as the html form
    once the user has log in the page will redirect the user to index.php-->
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>

        <?php include '../libraries.php'; ?>
    </head>

    <body>
        <!--ESTO NO FUNCIONA POR ALGUNA RAZON-->
        <?php include '../header.php'; ?>


        <form action="#" method="POST">

            <div class="loginContainer">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <button type="submit">Login</button>

            </div>

            <div class="loginContainer">
                <button type="button" class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
        </form> 

    </body>

</html>

<?php
//start session
session_start();

//Connect to database
$con = mysqli_connect("localhost", "root", "");

//hadle the form and validate the input
if (isset($_POST['username']) && isset($_POST['password'])) {

    $userName = $_POST['username'];
    $password = $_POST['password'];


//check connection
    if (!$con) {
        die("ERROR: Can't connect to host");
    }
    $db = mysqli_select_db($con, "pa_proyecto_final");

    if (!$db) {
        die("ERROR: Can't connect to DB ");
    }



//Save values in an array and sanitize them
    $arraySanitize = array('userName' => FILTER_SANITIZE_STRING,
        'password' => FILTER_SANITIZE_STRING);

//filter the values
    $formInput = filter_input_array(INPUT_POST, $arraySanitize);

//now do the DB search
//first sql sentence to find user in the DB
    $sql = "SELECT * FROM usuario WHERE Mail LIKE '" . $userName . "';"; //username is email
    $query = mysqli_query($con, $sql);

    if (!$query) {//if we don't get an error here we found a user
        mysqli_close($con);
        die("ERROR: There is an error in the LOGIN");
    } else if (mysqli_num_rows($query) == 1) {

        $aux = mysqli_fetch_array($query); //get the query result into an array
        //print_r($aux);
        //if (password_verify($password, $aux['Pass'])) {//using password_verify without hashing the DB passwords causes an error
        //not finding any user
        if ($password === $aux['Pass']) {
            //user found

            mysqli_close($con);

            //create session values once the user has been found in the DB
            $_SESSION['user'] = $userName;
            $_SESSION['userID'] = $aux['Id'];
            $_SESSION['userRol'] = $aux['Rol'];
            //go back to index after login
            header("Location:index.php");
        } else {
            //user not found
            mysqli_close($con);
            die("User not found, mail and pass dont match");
        }
    }
}

