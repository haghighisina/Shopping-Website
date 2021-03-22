<?php session_start();
require_once __DIR__.'/includes.php';
require_once __DIR__.'/functions/login.php';
?>
<div class="container w-25 form-group mt-5 border rounded">
    <h3 class="text-left mt-3 mb-3">Sign-In</h3>
    <form action="login.php" method="post">
        <?php if ($hasErrors ?? ''):?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($errors as $errorMessage):?>
                    <p><?= $errorMessage ;?></p>
                <?php endforeach;?>
            </div>
        <?php endif;?>
        <div class="form-group">
            <label for="username" class="form-label font-weight-bold">Name</label>
            <input type="text" name="username" value="<?= empty($username) ? '' : $username;?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="password" class="form-label font-weight-bold">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="g-recaptcha" data-sitekey="6LdsrtgZAAAAAJn9era88xaoM9DAJ8-1XPJvpfkC"></div>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <input type="hidden" name="token" value="<?= CreateToken() ;?>">
        <button type="submit" name="submit" class="mb-3 form-control btn btn-primary">Continue</button>
    </form>
</div>
<div class="container w-25 form-group mt-2">
   <hr><a href="register.php" type="submit" name="submit" style="background-color: lightgray;" class="mb-2 border border-dark form-control btn">Create your account</a>
</div>
