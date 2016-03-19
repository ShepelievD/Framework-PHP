<?php
$date = new \DateTime();
$date->setTimestamp(strtotime($post->date));
?>

<div class="row">
    <h1><?php echo $post->title ?></h1>

    <p class="small"><?php echo $date->format('F j, Y H:i:s') ?></p>
    <?php echo htmlspecialchars_decode($post->content) ?>
</div>