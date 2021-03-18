<?php
$flashmessanger = notificationMessage();
$hasMessage = count($flashmessanger) > 0;
$flashErrorMessenger = notificationErrorMessage();
$hasErrorMessage = count($flashErrorMessenger) > 0;
?>
<section class="container">
    <?php if ($hasMessage):;?>
        <div class="alert alert-success">
            <?php foreach($flashmessanger as $message):;?>
                <?= $message;?>
            <?php endforeach;?>
        </div>
    <?php endif;?>
    <?php if ($hasErrorMessage):;?>
        <div class="alert alert-danger">
            <?php foreach($flashErrorMessenger as $Errormessage):;?>
                <?= $Errormessage;?>
            <?php endforeach;?>
        </div>
    <?php endif;?>
</section>