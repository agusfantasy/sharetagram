<div class="thumb-cont">
    <h2><?php echo (isset($title)?$title:''); ?></h2>

    <ul class="row list-inline" id="tagsul">
    </ul>

    <div class="morebox" >
        <div id="more-tag" class="more btn btn-default" data-max-id="" data-tag="<?php echo $tag ?>" style="display: none">
            Load More
        </div>
        <i id="loading" class="fa fa-spinner fa-spin fa-2x"></i>
    </div>
</div>