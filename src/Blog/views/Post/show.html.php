<?php
$date = new \DateTime();
$date->setTimestamp(strtotime($post->date));
?>

<div class="row">
    <h1><?php echo $post->title ?></h1>

    <p class="small"><?php echo $date->format('F j, Y H:i:s') ?></p>
    <?php echo htmlspecialchars_decode($post->content) ?>
    <?php if( \Framework\DI\Service::get('security')->isAuthenticated()){ ?>
        <hr>
        <br>
    <div>
        <a href=" <?php $editRoute = $getRoute('edit_post');
                echo str_replace('{id}', $post->id, $editRoute); ?>
        "><span class="glyphicon glyphicon-pencil"></span> Edit</a>
    </div>
    <div>
        <a style="color: red" href="<?php $removeRoute = $getRoute('remove_post');
            echo str_replace('{id}', $post->id, $removeRoute); ?>"
            ><span class="glyphicon glyphicon-trash"></span> Remove
        </a>
    </div>
    <?php } ?>
</div>