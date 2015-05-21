<div class="row">
    <?php $this->load->view('user/user_header') ?>
</div>

<?php
    if (empty(ur(4))) :
        $this->load->view('view_media');
    elseif (ur(4) == 'followers' || ur(4) == 'followings') :
        $this->load->view('view_user');
    endif;
?>