<div style="height:50px"></div>
<div class="center">
    <h3><?php echo $error ?></h3>
    <br>
    <button class="btn btn-primary" onclick="goBack(this)" id="<?php echo isset($link)?$link:""; ?>" >
        <?php echo isset($back_text)?$back_text:"Back"; ?>
    </button>
</div>