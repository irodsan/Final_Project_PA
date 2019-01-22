<!--This page contains all the php and html code for the registration of a new user-->

<html>

    <head>
        <meta charset="UTF-8">
        <title></title>

        <?php include '../libraries.php'; ?>
    </head>

    <body>

        <?php
        include_once '../header.php';

        function registrationForm() {
            ?>

            <form action="#" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Email">
                        <small class="form-text text-muted">Your email will be also your surname and used to log-in</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"
                         <label for="inputName" >Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputLastName">Last Name</label>
                        <input type="text" name="lastName" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNumber">Phone number</label>
                        <input type="text" name="phoneNumber" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCard">Card Number</label>
                        <input type="text" name="cardNumber" class="form-control">
                        <small class="form-text text-muted">We wont steal your money we promise</small>
                    </div>

                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="hasCar" onclick="showCarForm('hasCar', 'carValuesID', null, 'on')" unchecked>
                        <label class="form-check-label" for="gridCheck">
                            Do you own a car?
                        </label>
                    </div>
                </div>
                <div id="carValuesID" class="form-row" style="display: none">
                    <div class="form-group col-md-6">
                        <label for="inputCard">Plate Number</label>
                        <input type="text" name="plateNumber" class="form-control">

                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCard">Car slots</label>

                        <input type="text" name="slots" class="form-control">

                    </div>
                </div>
                <button type="submit" name="send" class="btn btn-primary">Sign up</button>
            </form>



            <?php
        }

        registrationForm();

        print_r($_POST);
        if (isset($_POST['send'])) {
            //first we sanitize all inputs 
            //     if (empty($error)) {

            $arraySanitize = array(
                'name' => FILTER_SANITIZE_STRING,
                'lastName' => FILTER_SANITIZE_STRING,
                'email' => FILTER_SANITIZE_STRING,
                'password' => FILTER_SANITIZE_STRING,
                'phoneNumber' => FILTER_SANITIZE_NUMBER_INT,
                'cardNumber' => FILTER_SANITIZE_STRING,
                'plateNumber' => FILTER_SANITIZE_STRING,
                'slots' => FILTER_SANITIZE_NUMBER_INT);
            //       }
            //form validation
            $error = [];
            // then check requiered fields for errors

            if (!isset($_POST['name']) || $_POST['name'] == "") {
                $error[] = "Name can't be empty";
            }
            if (!isset($_POST['lastName']) || $_POST['lastName'] == "") {
                $error[] = "Last name can't be empty";
            }
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error[] = "Email not valid";
            }
            if (strlen($_POST['password']) < 8) {
                $error[] = "Password must contain at least 8 characters";
            }

            if (!filter_var($_POST['phoneNumber'], FILTER_VALIDATE_INT)) {
                $error[] = "Phone Number not valid";
            }

            //number of slots in the car are optional thus we check before that they are filled
            if (isset($_POST['slots']) && !empty($_POST['slots'])) {
                if (!filter_var($_POST['slots'], FILTER_VALIDATE_INT)) {
                    $error[] = "Slots not valid";
                }
            }
            print_r($error);

            //filtered array
            $formInput = filter_input_array(INPUT_POST, $arraySanitize);

            //get values from filtered array
            $name = $formInput['name'];
            $lastName = $formInput['lastName'];
            $userName = $formInput['email']; //username is email
            $password = $formInput['password'];
            $phoneNumber = $formInput['phoneNumber'];

            //optional values
            if (isset($formInput['cardNumber'])) {
                $cardNumber = $formInput['cardNumber'];
            } else {
                $cardNumber = "";
            }
            if (isset($_POST['plateNumber'])) {
                $plateNumber = $formInput['plateNumber'];
                $rol = "conductor"; //set user rol to driver in case he has a vehicle
            } else {
                $rol = "cliente";
            }
            if (isset($_POST['slots'])) {
                $carSlots = $formInput['slots'];
            } else {
                $carSlots = false;
            }

            //hash the password
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);

            //conect to DB
            $con = dbConnection();

            //sql sentence for inserting user
            //echo $name . "<br/>";
            $sqlUser = "INSERT INTO usuario ( Id, Name, LastName, Mail, Pass, Phone,"
                    . " Credit_card, Rol) VALUES ('NULL', '" . $name . "', '" . $lastName
                    . "', '" . $userName . "', '" . $hashedPass . "', '" . $phoneNumber
                    . "', '" . $cardNumber . "', '" . $rol . "')";

            echo $sqlUser;
            //insert into DB
            $query1 = mysqli_query($con, $sqlUser);

            if (!$query1) {
                echo "error sql1";
                $error[] = "User already registered";
                mysqli_close($con);
            } else {
                echo "true";

                //get the automated generated id from last query
                $user_id = mysqli_insert_id($con);

                //if slots is true means theres a number thus a driver and a car to insert
                if (!$slots) {
                    //sql sentence for inserting vehicle
                    $sqlVehicle = "INSERT INTO vehiculo (Matricula, Plazas, Propietario_id)"
                            . " VALUES ('" . $plateNumber . "', " . $carSlots . "', '" . $user_id
                            . "')";

                    //insert vehicle into DB
                    $query2 = mysqli_query($con, $sqlVehicle);
                }

                $_SESSION["user"] = $userName;
                $_SESSION["user_id"] = $user_id;
                $_SESSION["type"] = $rol;

                if (!$query2) {
                    $error[] = "Vehicle already registered";
                }


                mysqli_close($con);
                header("Location: index.php");
            }
        }
        ?>




    </body>

</html>

<script>
    //Esta funcion sirve para mostrar o ocultar distintos campos del formulario
    //en funcion de el valor de cmpValor que le pasemos
    //ocultara idElem si no se cumple y mostrara idElem2 en el caso de
    //que se le haya mandado alguno
    //Funsion sedida por el gran Am3
    function showCarForm(idValor, idElem, idElem2, cmpValor) {
        var x = document.getElementById(idElem);
        var valor = document.getElementById(idValor);
        if (idElem2 != null) {
            var x2 = document.getElementById(idElem2);
        }
        if (valor.value == cmpValor) {
            x.style.display = "block";
            if (x2 != null) {
                x2.style.display = "none";
            }

            return true;
        } else if (valor.value != cmpValor) {
            x.style.display = "none";
            if (x2 != null) {
                x2.style.display = "block";
            }

        }
        return false;
    }
</script>