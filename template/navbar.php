<?php logData("INFO","Header PAGE",['user_id'=>$userId]);?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand mx-3" href="index.php" style="color: #0c5460">Shopping <span style="color: #e0a800">Cart</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"></div>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mr-auto">
                <li class="navbar-item active">
                    <a href="index.php" class="nav-link" id="nav-link">Home</a>
                </li>
                <li class="navbar-item">
                    <a href="cardItems.php" class="nav-link">Product</a>
                </li>
                <?php if (isLoggedIn()):?>
                <li class="navbar-item">
                    <a class="nav-link" href="edit.php">Edit</a>
                </li>
                <li class="navbar-item">
                    <a class="nav-link" href="shopping_cart.php">Cart</a>
                </li>
                <?php endif;?>
                <?php if(!isLoggedIn()):?>
                <li class="navbar-item">
                    <a class="nav-link menu-right-btn" href="login.php">Sign In</a>
                </li>
                <?php else:?>
                <li class="navbar-item">
                    <a class="nav-link menu-right-btn" href="logout.php">Logout</a>
                </li>
                <?php endif;?>
            </ul>
            <form  method="POST" action="search.php" class="form-inline d-flex my-2 my-lg-0">
                <input class="form-control search-bar" name="search" type="search" placeholder="Search">
                <button class="btn btn-search mr-2 pr-5" name="submitSearch" type="submit">Search</button>
            </form>
        </div>
    </nav>
</header>
<?php require_once __DIR__.'/../action/message_action.php'; ?>


