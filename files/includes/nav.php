<?php if (isset($_SESSION['loggedIn'])) {$nav = "Logout";} else {$nav = "Login";} ?>
<nav role="navigation" class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Pony Demographics</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle Navigation">
        <span class="navbar-toggler-icon"></span>
    </button>



    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/survey">Survey <span class="sr-only"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/results">Results <span class="sr-only"></span></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['userName'])) {echo '
            <li class="nav-item">
                <a class="nav-link" href="/profile"><i class="fas fa-user-circle"></i>' . ' ' . $_SESSION["userName"] . '</a>
            </li>';} ?>
            <li class="nav-item">
                <a class="nav-link" href="/<?php echo strtolower($nav)?>"><?php echo $nav?><class="sr-only"></span></a>
            </li>
        </ul>
    </div>
</nav>