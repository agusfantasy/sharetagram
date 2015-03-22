<i ng-click="isLiked()"
   id="like" data-self-id="<?php echo session('ig_id') ?>"
   data-status="<?php $is_liked ?>"
   class="fa fa-heart fa-lg <?php echo $is_liked ? 'liked' : ''   ?>"  ></i>

<span class="count" ><b id="like-count"><?php echo $likes->count ?></b> Like</span>
<div ng-hide="like_data" class="row">
    <ul>
        <?php foreach ($likes->data as $row): ?>
            <li id="<?php echo $row->id; ?>">
                <a href="<?php echo site_url("/user/$row->id/$row->username") ?>">
                    <?php echo $row->username ?>
                </a>
            </li>
        <?php endforeach ?>
        <div class="clr"></div>
    </ul>
</div>
<div ng-hide="like_view_all" class="link-click-all" ng-click="likes()" > &gt; VIEW ALL  </div>
<div ng-show='like_loading'><i id="loading" class="fa fa-spinner fa-spin fa-2x"></i></div>
<div class="row">
    <ul>
        <li ng-repeat="row in like_rows">
            <a href="/user/{{ row.id }}/{{ row.username }}">
                {{ row.username }}
            </a>

        </li>
    </ul>
</div>
<div class="clr"></div>