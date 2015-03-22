<div style="height:50px"></div>
<div class="center">
    <h3><?php echo $error; ?></h3>
    <br>
    <a class="btn btn-primary" href="<?php echo isset($link)?$link:base_url(); ?>" >
        <?php echo isset($back_text)?$back_text:"Back"; ?>
    </a>
</div>