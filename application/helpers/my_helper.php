<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

use Emojione\Emojione;

function humanTiming ($time)
{
	//$time = strtotime('2010-04-28 17:25:43');
    $time = time() - $time; // to get the time since that moment

	$tokens = array (
        31536000 => 'y',
        2592000 => 'm',
        604800 => 'w',
        86400 => 'd',
        3600 => 'h',
        60 => 'min',
        1 => 's'
    );
	
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);

		return $numberOfUnits.$text;
    }

}

function pr($p){
	echo "<pre>";
	print_r ($p);
	echo "</pre>";	
	return TRUE;
}

function getCI(){
	$CI =& get_instance();
	return $CI; 
}

function fb(){
	$CI =getCI();
	return array(
		'id' => $CI->config->item('app_fb_id'),
		'key'=> $CI->config->item('app_fb_key')
	);
}

function tw(){
	$CI =getCI();
	return array(
		'key' => $CI->config->item('tw_app_key'),
		'secret'=> $CI->config->item('tw_app_secret')
	);
}

function ur($i){
	$CI =getCI();
	return $CI->uri->segment($i);
}

function file_url(){
	$CI =getCI();
	return $CI->config->item('file_url'); 
}
function file_path(){
	$CI =getCI();
	return $CI->config->item('file_path');
}

function img_url(){
	$CI =getCI();
	return $CI->config->item('img_url');
}
function img_path(){
	$CI =getCI();
	return $CI->config->item('img_path');
}

function asset_url(){
	$CI =getCI();
	return $CI->config->item('asset_url');
}
function asset_path(){
	$CI =getCI();
	return $CI->config->item('asset_path');
}

function cfg($o='app_name'){ 
	$CI =getCI();
	$return = '';

	$logic = '';
	if(is_array($CI->config->item($o))){
		$logic = count($CI->config->item($o))>0?1:"";
	}else{
		$logic = $CI->config->item($o);
	}

	if(trim($logic)!=""){
		$return = $CI->config->item($o);
	}else{
		$v = $CI->db->get_where("app_config",array(
				'config_name' => $o
			))->row();
		if(count($v)>0)
			$return = $v->config_value;
	}

	return $return;
}

function session($key)
{
    $CI =getCI();
    return $CI->session->userdata($key) ;
}

function instagram_token(){
    $CI =getCI();
    return $CI->config->item('instagram_token');
}

function get($str){
    $CI =getCI();
    return $CI->input->get($str);
}

function post($str){
    $CI =getCI();
    return $CI->input->post($str);
}

function emoji($str){    
    return Emojione::unicodeToImage($str);
}
?>