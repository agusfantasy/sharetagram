<div class="user-detail-profil col-md-7">
    <div class="user-detail-profil-avatar">
        <img src="<?php echo $user->data->profile_picture ?>">
    </div>
    <div class="user-detail-profil-info">
        <b><?php echo $user->data->username ?></b><br>
        <?php echo $user->data->full_name ?>
        <p> <?php echo parse_smileys($user->data->bio , base_url()."images/smileys/") ?> </p>
        <a target="_blank" title="<?php echo $user->data->website ?>"
           href="<?php echo $user->data->website ?>"><?php echo $user->data->website ?></a>
    </div>
</div>

<div class="user-detail-action col-md-5">
    <?php
    $fstyle_self = '';
    if ($user_self_id == $user->data->id) {
        $fstyle_self = 'style="background-color: rgba(0, 0, 0, 0);color: rgba(0, 0, 0, 0);cursor: none;"';
    }
    ?>
    <a href="#" class="btn btn-primary btn-large follow">
        <div id="follow" data-id="<?php echo $fid; ?>">
            <?php echo $following; ?>
        </div>
    </a>

    <a class="btn btn-default" href="<?php echo "/user/{$user->data->id}/{$user->data->username}"; ?>">
        <b> <?php echo $user->data->counts->media; ?> </b> <br> media
    </a>

    <a class="btn btn-default"
       href="<?php echo "/followings/{$user->data->id}/{$user->data->username}"; ?>">
        <b> <?php echo $user->data->counts->follows; ?> </b> <br> followings
    </a>

    <a class="btn btn-default"
       href="<?php echo "/followers/{$user->data->id}/{$user->data->username}"; ?> ">
        <b> <?php echo $user->data->counts->followed_by; ?> </b> <br> followers
    </a>
</div>