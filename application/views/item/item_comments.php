<span class="comment-sp sprite" style="margin-top: 5px;"></span>
<span class="count"><b><?php echo $comments->count ?></b>  Comment </span>

<div ng-hide="comment_data">
    <ul>
        <?php $n = 0; ?>
        <?php foreach ($comments->data as $row): ?>
            <?php $n++; ?>
            <?php if ($n < 6): ?>
                <li>
                    <div class="row">
                        <div class="pull-left">
                            <img alt="<?php echo $row->from->username ?>" width="30" height="auto"
                                 src="<?php echo $row->from->profile_picture; ?>">
                        </div>
                        <div class="pull-right" style="width: 88%;">
                            <div>
                                <span class="pull-left">
                                    <a title="<?php echo $row->from->username; ?>"
                                       href="<?php echo "/user/{$row->from->id}/{$row->from->username}" ?>">
                                       <?php echo $row->from->username ?>
                                    </a>
                                </span>
                                <span class="comment-time pull-right"><?php echo humanTiming($row->created_time) ?></span>

                                <div class="clr"></div>
                            </div>
                            <div class="text"><?php echo \Emojione\Emojione::unicodeToImage($row->text); ?></div>
                        </div>
                    </div>
                    <div class="clr"></div>
                </li>
            <?php endif ?>
        <?php endforeach ?>
    </ul>
</div>

<?php if ($comments->count > 5): ?>
    <div ng-hide="comment_view_all" class="link-click-all" ng-click="comments()"> &gt; VIEW ALL</div>
<?php endif ?>

<div ng-show="comment_loading"><i id="loading" class="fa fa-spinner fa-spin fa-2x"></i></div>
<div class="row">
    <ul>
        <li ng-repeat="row in comment_rows">
            <div class="row">
                <div class="pull-left">
                    <img alt="" width="30" height="auto" src="{{ row.from.profile_picture }}">
                </div>
                <div class="pull-right" style="width: 88%;">
                    <div>
                                        <span class="pull-left">
                                            <a title="{{ row.from.username }}"
                                               href="/user/{{ row.from.id }}/{{ row.from.username }}">
                                                {{ row.from.username }}
                                            </a>
                                        </span>
                        <span class="comment-time pull-right">{{ row.created_time }}</span>

                        <div class="clr"></div>
                    </div>
                    <div class="text" ng-bind-html="row.text"></div>
                </div>
            </div>
            <div class="clr"></div>
        </li>
    </ul>
</div>