<div class="user-detail-profil col-md-7">
    <div class="user-detail-profil-avatar">
        <img src="<?php echo $user->data->profile_picture ?>">
    </div>
    <div class="user-detail-profil-info">
        <b><?php echo $user->data->username ?></b><br>
        <?php echo emoji($user->data->full_name) ?>
        <p> <?php echo emoji($user->data->bio) ?> </p>
        <a target="_blank" title="<?php echo $user->data->website ?>"
           href="<?php echo $user->data->website ?>"><?php echo $user->data->website ?></a>
    </div>
</div>

<div class="user-detail-action col-md-5">
    <a href="#" id="follow" data-self-id="<?php echo session('ig_id') ?>"
       data-user-id="<?php echo $user->data->id ?>" data-rel-status="<?php echo $rel_status; ?>" class="btn <?php echo $rel_class ?> btn-large follow">
         <?php echo $rel_status; ?>
    </a>

    <a class="btn btn-default" href="<?php echo "/user/{$user->data->id}/{$user->data->username}"; ?>">
        <b> <?php echo $user->data->counts->media; ?> </b> <br> media
    </a>

    <a class="btn btn-default"
       href="<?php echo "/user/{$user->data->id}/{$user->data->username}/followings"; ?>">
        <b> <?php echo $user->data->counts->follows; ?> </b> <br> followings
    </a>

    <a class="btn btn-default"
       href="<?php echo "/user/{$user->data->id}/{$user->data->username}/followers"; ?> ">
        <b> <?php echo $user->data->counts->followed_by; ?> </b> <br> followers
    </a>
</div>