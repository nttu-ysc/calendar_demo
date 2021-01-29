<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Calendar</a>
        <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a class="nav-link">
                        <?php session_start();
                        echo $_SESSION['name'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>