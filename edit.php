<?php session_start();
require_once __DIR__.'/includes.php';
require_once __DIR__ . '/functions/edit.php';
if (isLoggedIn()):?>
    <div class="container form-group mt-5 border rounded" style="background-color: white">
       <h3 class="text-center" style="font-family: 'Lato';">You can edit your name and password</h3>
        <form method="POST" action="<?= escape($_SERVER['PHP_SELF']);?>" class="form-group">
             <?php if ($hasErrors ?? []): ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($errors as $errorMessage):?>
                    <p><?= empty($errorMessage) ? : $errorMessage ;?></p>
                <?php endforeach; ?>
            </div>
        <?php endif;?>
            <div class="form-group">
                <label for="username" class="form-label">Name</label>
                <input type="text" name="username" value="<?= empty($username) ? '' : $username ;?>" class="form-control font-weight-bold" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control font-weight-bold" placeholder="At least 6 characters">
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control font-weight-bold" placeholder="Email">
            </div>
            <button  type="submit" name="submit" class="form-control mt-2 mb-2 btn btn-primary font-weight-bold">Submit</button>
        </form>
    </div>
<?php endif;?>
<?php require_once __DIR__.'/template/footer.php';?>

