<ul class="inline">
    <?php foreach ($users->data as $row): ?>
        <?php $userlink = "/user/$row->id/$row->username" ?>
        <li>
            <a class="photo" href="<?php echo $userlink ?>"><img src="<?php echo $row->profile_picture ?>"></a>
            <a class="name " href="<?php echo $userlink ?>">@<?php echo $row->username ?></a><br>
            <a class="name hidden-xs" href="<?php echo $userlink ?>"><?php echo emoji($row->full_name) ?></a>

            <div class="clr"></div>
        </li>

    <?php endforeach ?>
</ul>