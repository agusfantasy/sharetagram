<?php
$con = 'count';
foreach ($recent_data as $row): ?>
    <?php
    $icon_play = '';
    if ($row->type == 'video') {
        $icon_play = "<div class='hasvideo' style='top:60px;left:58px;'><div class='play'></div></div>";
    }

    if ($this->M->checkSelfLike($row->id)) {
        $fclass = 'like-icon-active';
        $fclick = 'unlike';
        $fstyle = 'margin:3px 1px 0 0';
    } else {
        $fclass = 'like-icon';
        $fclick = 'like';
        $fstyle = 'margin-right: 1px';
    }
    ?>

    <li id="<?php echo $row->id; ?>" style="padding: 10px 10px 5px;">

        <?php if (ur(2) == 'feed'): ?>
            <div class="name">
                <a href="<?php echo site_url("user/$row->user->id/$row->user->username"); ?>"><?php echo substr($username, 0, 21); ?></a>
            </div>
        <?php endif ?>

        <div class="img">
            <div style="display:none" class="rec-mg" id="rec-mg<?php echo $row->id; ?>">
                <a href="<?php echo base_url() . "m/$row->id" ?>">
                    <img id="<?php echo $row->id ?>" height="150" width="150"
                         src="<?php echo $row->images->thumbnail->url; ?>"><?php echo $icon_play; ?>
                </a>
            </div>
        </div>

        <div class="photo-time"><?php echo humanTiming($row->created_time); ?></div>

        <div class="like-com">
            <span style="<?php echo $fstyle; ?>" class="icon-like <?php echo $fclass; ?>"
                  onclick="<?php echo $fclick; ?>('<?php echo $row->id ?>')" id="like<?php echo $row->id ?>"></span>

            <div style="float:left;" class="like-count" data-total="<?php echo $row->likes->$con ?>"
                 id="likecount<?php echo $row->id ?>" data-id="<?php echo $row->id ?>">
                <?php echo $row->likes->$con ?>
            </div>

            <div style="float:left;  margin: 4px 0 3px 5px;" class="icon-comment"></div>&nbsp;<?php echo $row->comments->$con ?>
        </div>

    </li>

<?php endforeach ?>

<div class="clr"></div>

<div style="display:none" id="loading" class="loading">
    <img src="<?php echo base_url() ?>images/animated_loading.gif">
</div>

<?php if (isset($next)): ?>
    <div id="more<?php echo $next ?>" class="morebox">
        <div class="more btn btn-default" id="<?php echo $next ?>"> Load More </div>
    </div>
<?php endif ?>

<?php $this->load->view('user/recent_js'); ?>
<?php $this->load->view('site_js'); ?>