<?php $this->load->view('user/detail_header')?>
<div class="clr"></div>	
<div class="thumb-cont">
	<ul class="row list-inline" id="flowersul">
		<?php $this->load->view('user/flower_more');?>
		<div class="clr"></div>
	</ul>
</div>

<div id="loading" class="loading" > 
	<img src="<?php echo base_url()?>images/animated_loading.gif" >
</div>