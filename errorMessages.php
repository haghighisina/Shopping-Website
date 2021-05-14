<?php if ($hasErrors ?? []): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($errors as $errorMessage):?>
            <p><?= empty($errorMessage) ? : $errorMessage ;?></p>
        <?php endforeach; ?>
    </div>
<?php endif;?>
