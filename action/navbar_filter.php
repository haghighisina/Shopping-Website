<nav class="navbar navbar-light bg-light px-3">
    <a class="navbar-brand" href="#"></a>
    <ul class="nav nav-pills">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Filter Product By Time</a>
            <ul class="dropdown-menu" style="right: 10px">
                <form method="POST" action="<?= escape('filterproduct.php');?>" class="form-group">
                    <input type="hidden" name="low1" value="<?="2019-07-22";?>">
                    <input type="hidden" name="high1" value="<?="2020-08-22";?>">
                    <button type="submit" name="filter" class="btn btn-outline-primary btn-small filter">2019-07 &nbsp;- &nbsp;2020-08</button>
                </form>
                <form method="POST" action="<?= escape('filterproduct.php');?>" class="form-group mt-1">
                    <input type="hidden" name="low2" value="<?="2019-07-22";?>">
                    <input type="hidden" name="high2" value="<?="2021-08-22";?>">
                    <button type="submit" name="filter2" class="btn btn-outline-primary btn-small filter">2019-07 - The latest</button>
                </form>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Filter Product By Price</a>
            <ul class="dropdown-menu" style="right: 1px">
                <li style="width: 300px">
                    <form method="POST" action="<?= escape('filterproduct.php');?>" class="form-group d-flex w-100" >
                        <input type="text" name="lowPrice" class="form-control input px-3 text-center " value="50000" min="50000" max="140000">
                        <input type="text" name="highPrice" class="form-control input float-right px-3 " value="140000" min="50000" max="140000">
                        <button type="submit" class="form-control btn btn-outline-primary btn-small center w-25" aria-hidden="true" name="Filtersubmit">
                            <i class="fa fa-play"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>