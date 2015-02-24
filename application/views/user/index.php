<div class="row">
    <?php $this->load->view('user/index_header') ?>
</div>

<div class="row">
    <div class="thumb-cont user-recent">
        <ul class="row list-inline" id="tagsul">

        </ul>
    </div>
</div>

<div class="morebox">
    <div id="more-user-recent" class="more btn btn-default" data-max-id="" data-user-id="<?php echo $user->data->id ?>"
         style="display: none">
        Load More
    </div>
    <i id="loading" class="fa fa-spinner fa-spin fa-2x"></i>
</div>


