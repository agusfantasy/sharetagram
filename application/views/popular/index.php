<div class="thumb-cont popular">

    <h2><?php echo (isset($title)?$title:''); ?></h2>

    <ul class="row list-inline" id="tagsul">
        <?php foreach($query->data as $row):  ?>
            <li>
                <div class="wrapper">

                    <div class="name">
                        <a href="<?php echo site_url("user/{$row->user->id}/{$row->user->username}");?>">
                            <?php echo substr($row->user->username,0,21) ;?>
                        </a>
                    </div>

                    <div class="img" id="img">
                        <a href="<?php echo "/m/$row->id" ?>">
                            <img class="lazy" src="/images/loading.bax-shop.nl.gif" data-original="<?php echo $row->images->thumbnail->url ?>">
                            <?php if ($row->type == 'video'): ?>
                                <div class="has-video"><div class="play"></div></div>
                            <?php endif ?>
                        </a>
                    </div>

                    <div class="field">
                        <div class="photo-time"><?php echo humanTiming($row->created_time); ?></div>
                        <div class="like-comment">
                            <i class="fa fa-heart-o fa-fw"></i> <?php echo $row->likes->count?>
                            <i class="fa fa-comment fa-fw"></i> <?php echo $row->comments->count?>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </li>
        <?php endforeach ?>
    </ul>

    <div class="morebox" >
        <a href="/popular" class="btn btn-success"> Refresh</a>
    </div>

 </div>