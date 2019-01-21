
<!--This page contains all html and php code for the login of the users
    All of the vaidations will be done in the this same page as the html form-->
<html>
    
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
    
    
</html>

<?php
    //start session
    session_start();
    //hadle the form and validate the input

    $userName = $_POST["username"];
    $password = $_POST["password"];

    //Save values in an array and sanitize them
    $arraySanitize = array('userName' => FILTER_SANITIZE_STRING,
                            'password' => FILTER_SANITIZE_STRING);
    
    //filter the values
    $formInput = filter_input_array(INPUT_POST, $arraySanitize);
    
    //now do the DB search
    
    //create session values once the user has been found in the DB
    $_SESSION['user'] = $userName;
    //$_SESSION['userID'] = from DB
    //$_SESSION['userType'] = from DB
    //go back to index after login
    header("Location:index.php");
    

