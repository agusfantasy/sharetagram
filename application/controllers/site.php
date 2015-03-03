<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller
{
	public function __construct()
    {
		parent::__construct();
		$this->load->model('InstagramModel','model');
	}

    public function index()
    {
		$data['meta_title'] = "Sharetagram - Instagram web viewer online"; 
		$data['meta_description'] = "The best Instagram web viewer online, browse popular photos, tags, users.";
		$data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";
		$data['meta_image'] = base_url().'images/logo_500.png';

        $data['content'] = 'home/index';
		$this->load->view('layout/dashboard_view',$data);
	}
	
	public function check_like_user($id)
	{
		//get authentication user login if liked this photo
		$user_id = session('instagram-user-id');
		if (!empty($user_id)) {
			if ($id == $user_id) {
				echo $id."-".$user_id; 
				echo 1;
			} else {
				echo 0;
			}
		} else {
            echo 0;
        }
	}
	
	public function get_likes_self($mid)
    {
		$media_likes = $this->instagram_api->mediaLikes($mid);	
		//pr($media_likes);
		foreach($media_likes->data as $r){
			$like[] = $r->id;
		}

		return $like;
	}





    public function post_comment()
    {
		$media_id = $this->input->get('mid');
		$comment = $this->input->get('comment');

		$q = $this->instagram_api->postMediaComment($media_id,$comment);
		if ($q) {		
			//echo "sukses";
			$data['user_id'] = $this->session->userdata('instagram-user-id');
			$data['pp'] = $this->session->userdata('instagram-profile-picture');
			$data['username'] = $this->session->userdata('instagram-username');
			$data['text'] = $comment;
			$now = strtotime(date("Y-m-d H:i:s"));
			$data['time'] = humanTiming($now);
			$this->load->view('comment_detail_v',$data);
		}
		else {echo "failed";}
	}

    public function post_like()
    {
		$media_id = $this->input->post('mid');
		if($this->session->userdata('instagram-user-id')==''){	
			echo "You must login to like";
		}else{
			$q = $this->instagram_api->postLike($media_id);
			if ($q) { echo 1;}
			else {echo "false";}
		}
	}
	
	public function remove_like()
    {
		$media_id = $this->input->post('mid');
		//$media_id = $this->input->get('mid');
		if($this->session->userdata('instagram-user-id')==''){	
			echo "You should login to unlike";
		}
		else{
			$q = $this->instagram_api->removeLike($media_id);
			//echo "<pre>"; print_r($q); echo "</pre>";
			if ($q->meta->code==200) { echo 1;}
			else {echo "false";}
		}
	}
}