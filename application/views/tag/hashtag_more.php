<?php $con = 'count'; ?>

    <?php foreach($tag_data as $row):  ?>
	    <?php
            $images_150 = $row->images->thumbnail->url;
			$user_id = $row->user->id;
			$username = $row->user->username;
        ?>

        <?php $icon_play  = '';
		if($row->type=='video'){
	        $icon_play = "<div class='hasvideo' style='top:55px;left:53px;'><div class='play'></div></div>";
        } ?>

        <?php
			if ( $this->M->checkSelfLike($row->id) OR $this->uri->segment(2)=='my_likes' ){
				$fclass = 'like-icon-active';
				$fclick = 'unlike';
				$fstyle = 'margin:3px 1px 0 0';
			} else {
				$fclass = 'like-icon';
				$fclick = 'like';
				$fstyle = 'margin-right: 1px';
			}
			?>

			<li id="<?php echo $row->id;?>" >
				<div class="name"><a href="<?php echo site_url("user/$user_id/$username");?>"><?php echo substr($username,0,21) ;?></a></div>
				<div class="img" id="img<?php echo $row->id;?>">
					<!--<div class="noimage"><img src="<?php echo img_url()?>sharetagram-noimage.png"></div>-->
					<div style="display:none" class="tag-mg" id="tag-mg<?php echo $row->id;?>">
						<a href="<?php echo base_url()."m/$row->id"?>" >
							<img id="<?php echo $row->id;?>" src="<?php echo $images_150;?>">
						<?php echo $icon_play;?></a>
					</div>
				</div>
				<div class="photo-time"><?php echo humanTiming($row->created_time); ?></div>
				<div class="like-com">
					<span style="<?php echo $fstyle; ?>" class="icon-like <?php echo $fclass; ?>" onclick="<?php echo $fclick; ?>('<?php echo $row->id?>')"  id="like<?php echo $row->id?>"></span>
					<div style="float:left;" class="like-count" data-total="<?php echo $row->likes->$con?>" id="likecount<?php echo $row->id?>" data-id="<?php echo $row->id?>" > <?php echo $row->likes->$con?></div>
					<div style="float:left;  margin: 4px 0 3px 5px;" class="icon-comment"></div>&nbsp;<?php echo $row->comments->$con?>
				</div>
			</li>
	<?php endforeach?>