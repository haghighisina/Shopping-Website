<nav class="navbar navbar-light bg-light px-3">
    <a class="navbar-brand" href="#"></a>
    <ul class="nav nav-pills">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">price</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#scrollspyHeading3">Third</a></li>
                <li><a class="dropdown-item" href="#scrollspyHeading4">Fourth</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#scrollspyHeading5">Fifth</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">price</a>
            <ul class="dropdown-menu">
                <li>
                    <form method="POST" action="<?= escape('filterproduct.php');?>" class="form-group ">
                        <input type="text" name="lowPrice" class="form-control" value="50000" min="50000" max="140000">
                        <input type="text" name="highPrice" class="form-control my-1" value="140000" min="50000" max="140000">
                        <button type="submit" class="form-control btn btn-primary center" name="Filtersubmit">Submit</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
