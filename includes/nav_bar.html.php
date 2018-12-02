<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../index.html.php"><img class="img-responsive" width="195" height="71"
                                                           src="../images/logo.png"/></a>
        <form style="padding-top: 10px;" method="post" action="../index.html.php?categorie_id=<?php if (!empty($categorie_id)) {
            echo intval($categorie_id);
        } ?>">
            <div class="input-group mb-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"> <i  class="fa fa-search fa-9"></i></span>
                </div>
                <input type="text" class="form-control" placeholder="Search">
            </div>
        </form>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="../index.html.php">
                        Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/register_page.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/overons_page.html.php">Over ons</a>
                </li>

                <li id="shopping-cart-icon" class="nav-item active ">
                    <i class="blackiconcolor fa fa-shopping-cart fa-2x"></i>
                </li>
            </ul>
        </div>
    </div>
</nav>