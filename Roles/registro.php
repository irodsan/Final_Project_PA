<!--This page contains all the php and html code for the registration of a new user-->

<html>

    <head>
        <meta charset="UTF-8">
        <title></title>

        <?php include '../libraries.php'; ?>
    </head>

    <body>
        <!--ESTO NO FUNCIONA POR ALGUNA RAZON-->
        <?php
        include_once '../header.php';

        function registrationForm() {
            ?>

            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Email</label>
                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                        <small class="form-text text-muted">Your email will be also your surname and used to log-in</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"
                         <label for="inputAddress">Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress2">Last Name</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNumber">Phone number</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCard">Card Number</label>
                        <input type="text" class="form-control">
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
                        <input type="text" class="form-control">
                        <small class="form-text text-muted">We wont steal your money we promise</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCard">Car slots</label>
                        <small class="form-text text-muted">We wont steal your m
                        <input type="text" class="form-control">
                        <small class="form-text text-muted">We wont steal your money we promise</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Sign up</button>
            </form>



            <?php
        }

        registrationForm();
        ?>




    </body>

</html>

<script>
    //Esta funcion sirve para mostrar o ocultar distintos campos del
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