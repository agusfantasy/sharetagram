<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_contest extends CI_Model{
	
	private $token = '343655731.3693ac7.d5cf1a86a5f64b95817265199e796663';
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
		$this->instagram_api->access_token = $this->token;
		if($this->session->userdata('instagram-user-id')!=''){
			$this->user_self_id = $this->session->userdata('instagram-user-id');
		}else{
			$this->user_self_id = '';
		}
    }
	
	function getInfo($purl){
		$this->db->where('info_url',$purl);
		return $this->db->get('info');
	}
	
	function getUserList($p=array()){
		if(isset($p['email'])&& !empty($p['email'])){
			$this->db->where('email',$p['email']);
		}
		if(isset($p['ig_id'])&& !empty($p['ig_id'])){
			$this->db->where('ig_id',$p['ig_id']);
		}
		if(isset($p['ig_username'])&& !empty($p['ig_username'])){
			$this->db->where('ig_username',$p['ig_username']);
		}
		if( isset($p['offset']) && isset($p['limit']) ){
			$p['offset'] = empty($p['offset'])?0:$p['offset'];
			$this->db->limit($p['limit'],$p['offset']);
		}
		$this->db->limit(30,0);
		return $this->db->get('contest_user');
	}
	
	function addUser($p=array()){
		return $this->db->insert('contest_user',$p);
	}
	
	function getUserDetail($p){
		if($p=='id'){$this->db->where('user_id',$p);}
		if($p=='ig_username'){$this->db->where('ig_username',$p);}
		return $this->db->get('contest_user')->row();
	}
	
	function getContestList($p=array()){
		if(isset($p['id'])&& !empty($p['id'])){
			$this->db->where('contest_id',$p['contest_id']);
		}
		if(isset($p['name'])&& !empty($p['name'])){
			$this->db->where('contest_name',$p['name']);
		}
		if( isset($p['offset']) && isset($p['limit']) ){
			$p['offset'] = empty($p['offset'])?0:$p['offset'];
			$this->db->limit($p['limit'],$p['offset']);
		}
		$this->db->limit(30,0);
		$this->db->where('contest_status',1);
		return $this->db->get('contest');
	}
	
	// post list photos/videos by tag selected and store to db
	function insertIGtag($p=array()){
		$q = $this->db->insert('media',$p);
		if($q){	return TRUE;}
		return FALSE;
	}
	
	// get media list instagram from db
	function getMediaListIG($p=array(),$count=FALSE){
		
		$total = 0;
		$this->db->select('
				id, ig_media_id, ig_type, ig_images_150, ig_images_306, ig_images_612,
				ig_caption_text, ig_user_id, ig_user_name,ig_created_time,count_vote
			');
		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}	
		if(  isset($p['sort']) && isset($p['order']) ){
			$this->db->order_by($p['sort'],$p['order']);
		}else{
			$this->db->order_by('ig_created_time','desc');		
		}
		
		if(isset($p['id'])&& !empty($p['id'])){
			$this->db->where('id',$p['id']);
		}		
		if(isset($p['media_id'])&& !empty($p['media_id'])){
			$this->db->where('ig_media_id',$p['media_id']);
		}		
		if(isset($p['tag'])&& !empty($p['tag'])){
			$this->db->where('ig_hashtag',$p['tag']);
		}		
		if(isset($p['type'])&& !empty($p['type'])){
			$this->db->where('ig_type',$p['type']);
		}
		
		$qry = $this->db->get('media');
		if($count==FALSE){
			$total = $this->getMediaListIG($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}	
	}
	
	// get media list instagram from db
	// array parameter $pfield = field name,$pvalue = value
	function getMediaIG($pfield,$pvalue){ 
		$this->db->where($pfield,$pvalue);
		$q = $this->db->get('media')->row();
		if(count($q)==1){
			return $q;
		}
		return FALSE;
	}	
	
	//user list in one contest/one tag from db
	function getUser($tag){
		$this->db->select('id');
		$this->db->where('ig_hashtag',$tag);
		$this->db->group_by('ig_user_id');
		return $this->db->get('media');
	}
	
	//get voter by media_id from table voter
	function getVoter($media){
		$this->db->select('voter_media_id');
		$this->db->where('voter_media_id',$media);
		return  $this->db->get('voter');
	}
	
	//get voted by media_id & user id from table voter
	function getDetailVoted($media_id,$user_id){
		$this->db->select('voter_id');
		$this->db->where('voter_media_id',$media_id);
		$this->db->where('voter_user_id',$user_id);
		return  $this->db->get('voter')->row();
	}
	
	function addVoted($data){
		return $this->db->insert('voter',$data);	
	}
	
}
?>