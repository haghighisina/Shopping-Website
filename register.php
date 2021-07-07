<?php session_start();
require_once __DIR__.'/includes.php';
require_once __DIR__.'/functions/register.php';?>
<style>
    input:invalid {border-color: #ee1414;}
</style>
<div class="container w-25 form-group mt-5 border rounded">
    <h3 class="text-left mt-3 mb-3">Create account</h3>
    <form action="<?= escape($_SERVER['PHP_SELF']) ;?>" method="POST">
        <?php require_once __DIR__.'/errorMessages.php';?>
        <div class="form-group">
            <label for="username" class="form-label font-weight-bold">Name</label>
            <input type="text" name="username" value="<?= empty($username) ? '' : $username;?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password" class="form-label font-weight-bold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="At least 6 characters" required>
        </div>
        <div class="form-group">
            <label for="Re-password" class="form-label font-weight-bold">Re-password</label>
            <input type="password" name="Re-password" class="form-control" placeholder="At least 6 characters" required>
        </div>
        <div class="form-group">
            <label for="email" class="form-label font-weight-bold">Email</label>
            <input type="email" name="email" class="form-control" value="<?= empty($email) ? '' : $email;?>" required>
        </div>
        <div class="g-recaptcha" data-sitekey="6LdsrtgZAAAAAJn9era88xaoM9DAJ8-1XPJvpfkC"></div>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <button type="submit" name="submit" class="mb-3 form-control btn btn-primary">Create your account</button>
    </form>
</div>
