<!--Code for the header of the webpage
    This code is include in the header of index.php and the rest of the pages.-->
<header>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="#">Search trip</a>
            <a class="p-2 text-dark" href="#">Plan trip</a>

            <!-- notice that the Profile and the sigh up buttom will be changed so they switch between them-->
            <a href="#" class="dropdown-toggle active" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a href="#" class="dropdown-item">Panel</a>
                <a href="#" class="dropdown-item">Previous trips</a>
                <a href="#" class="dropdown-item">Profile settings</a>
                <a href="#" class="dropdown-item">My Forum</a>
                <a href="#" class="dropdown-item">Messages</a>
                <a href="#" class="dropdown-item">Close Session</a>
            </div>

        </nav>
        <a href="http://localhost/Final_Project_PA/Roles/login.php" class="btn btn-outline-primary" href="#">Sign in</a>
    </div>
</header>