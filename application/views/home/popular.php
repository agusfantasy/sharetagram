<?php if (!$popular_data && is_array($popular_data) == false) : ?>
    <div class="center">
        Can't retrive Instagram API popular data.
        Please click <a class="btn btn-primary" href="/">Refresh </a>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-md-12">
            <h1>Popular on Instagram</h1>
        </div>
    </div>
    <div class="row">
        <ul class="list-inline" >
            <?php $n = 0; ?>
            <?php foreach ($popular_data as $row) : ?>
                <?php $n++; ?>
                <?php if ($n < 9) : ?>
                    <li>
                        <a href="<?php echo base_url() . "m/$row->id"; ?>">
                            <img class="popular" alt="Popular on Instagram"
                                 src="<?php echo $row->images->low_resolution->url ?>">
                            <?php /*if ($row->type == 'video') : ?>
                                <div class="hasvideo">
                                    <img style="width:46px ; height:auto;" title="Play Instagram Video" alt="play"
                                         src="<?php echo img_url() ?>play.png">
                                </div>
                            <?php endif */?>
                        </a>
                    </li>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
    </div>

    <div class="center">
        <a href="<?php echo site_url('popular') ?>">More popular photos ...</a>
    </div>
<?php endif ?>