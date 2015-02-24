<?php $con = 'count'; ?>
<?php foreach($query as $row): ?>

    <li style="padding: 10px 10px 5px;">
        <div class="img">
            <div style="display:none;" class="flow" id="flow<?php echo $row->id; ?>">
                <a href="<?php echo site_url("user/$row->id/$row->username"); ?>">
                    <img id="<?php echo $row->id; ?>" width="150" height="150"
                         src="<?php echo $row->profile_picture; ?>">
                </a>
            </div>
        </div>

        <div class="name">
            <a href="<?php echo site_url("user/$row->id/$row->username"); ?>"><?php echo $row->username; ?></a>
        </div>
    </li>
			
<?php endforeach ?>
		
<?php if (!empty($cursor)):	?>
    <div style="display:block" id="more<?php echo $cursor; ?>" class="morebox">
        <div class="more btn btn-default" id="<?php echo $cursor; ?>">
            Load More
        </div>
    </div>
<?php endif ?>
	
<?php $this->load->view('user/flower_js')?>


