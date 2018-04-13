<nav role="navigation" class="navbar navbar-light navbar-toggleable-sm">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle Navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/">Pony Demographics</a>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto mt-2 mt-0">
            <li class="nav-item">
                <a class="nav-link" href="/survey">Survey <span class="sr-only"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/results">Results <span class="sr-only"></span></a>
            </li>
            <?php if (isset($_SESSION['loggedIn'])) {$nav = "Logout";} else {$nav = "Login";} ?>
            <li class="nav-item">
                <a class="nav-link" href="/<?php echo strtolower($nav) . '">' . $nav ?> <span class="sr-only"></span></a>
            </li>
            <?php if (isset($_SESSION['userName'])) {echo '<span class="user-navbar">' . $_SESSION["userName"] . '</span>';} ?>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-successful my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>