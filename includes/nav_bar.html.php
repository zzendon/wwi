<?php
$current = $_GET["current"];
session_start();
function highlight_current($current, $page)
{
    if ($current == $page) {
        echo 'active';
    }
}

?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../index.html.php"><img class="img-responsive" width="195" height="71"
                                                              src="../images/logo.png"/></a>
        <form style="padding-top: 10px;" method="post"
              action="../index.html.php?categorie_id=<?php if (!empty($categorie_id)) {
                  echo intval($categorie_id);
              } ?>">
            <div class="input-group mb-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"> <i class="fa fa-search fa-9"></i></span>
                </div>
                <input type="text" class="form-control" placeholder="Search">
            </div>
        </form>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php highlight_current($current, 'home'); ?>">
                    <a class="nav-link" href="../index.html.php"> Home </a>
                </li>
                <li class="nav-item <?php highlight_current($current, 'over_ons'); ?>">
                    <a class="nav-link" href="../pages/overons_page.html.php"> Over ons </a>
                </li>

                <?php
                if (isset($_SESSION['gebruikers_id']) && !empty($_SESSION['gebruikers_id'])) {
                    ?>
                    <li class="nav-item <?php highlight_current($current, 'account'); ?>">
                        <a class="nav-link" href="../pages/profile_page.php">Account</a>
                    </li>
                    <li id="shopping-cart-icon" class="nav-item active ">
                        <a href="../php/authentication/sign_out.php"> <i class="blackiconcolor fa fa-arrow-circle-right fa-2x"></i>
                        </a>
                    </li>
                <?php } else { ?>
                <li class="nav-item <?php highlight_current($current, 'Login'); ?>">
                    <a class="nav-link" href="../pages/register_page.php">Login</a>
                </li>
                <?php } ?>
                <li id="shopping-cart-icon" class="nav-item active ">
                    <a href="../pages/shopping_cart.html.php"> <i class="blackiconcolor fa fa-shopping-cart fa-2x"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>