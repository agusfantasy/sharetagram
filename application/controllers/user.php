<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include "configuration.php";

class User extends CI_Controller
{
	public function __construct()
    {
		parent::__construct();

        $this->load->model('InstagramModel','model');
        $this->model->setToken(instagram_token());
	}

    public function index($id)
    {
        $user = $this->model->getUser($id);

        if ($user->meta->code == 400) {
            redirect('user/private');
        }

        $data['user'] = $user;

        if (!empty(session('instagram-user-id'))) {
            if ($this->get_following_id($id) == 'follows') {
                $data['following'] = 'following';
                $data['fclass'] = 'following-box';
                $data['fid'] = 'unfollow';
            } else if ($this->get_following_id($id) == 'requested') {
                $data['following'] = 'requested';
                $data['fclass'] = 'requested';
                $data['fid'] = 'requested';
            } else {
                $data['following'] = 'follow';
                $data['fclass'] = 'follow-box';
                $data['fid'] = 'follow';
            }
        } else {
            $data['fclass'] = 'follow-box';
            $data['following'] = 'follow';
            $data['user_self_id'] = '';
            $data['fid'] = '';
        }

        $data['meta_title'] = "@{$user->data->username} -  {$user->data->full_name} on Instagram | Sharetagram";
        $data['meta_description'] = "{$user->data->full_name} Instagram Photo feed";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";

        $data['content'] = 'user/index';
        $this->load->view('layout/dashboard_view', $data);

    }

    public function recent()
    {
        $user_id = get('user_id');
        $max_id = get('max_id');

        $query = $this->model->getUserRecent($user_id, $max_id);

        if (!$query) {
            $response['alert'] = 'fail';
        } else {
            if ($query ===  429) {
                $response['alert'] = 'limit';
            } else {
                $response['alert'] = 'success';
                $response['code'] = $query->meta->code;

                $response['max_id'] = '';
                if (property_exists($query->pagination,'next_max_id')) {
                    $response['max_id'] =  $query->pagination->next_max_id;
                }

                $response['data'] = '';
                if (!empty($query->data)) {
                    foreach ($query->data as $k => $row) {
                        $obj = new stdClass();
                        $obj->id = $row->id;
                        $obj->type = $row->type;

                        $obj->has_video = '';
                        if ($obj->type == 'video') {
                            $obj->has_video =  '<div class="has-video"><div class="play"></div></div>';
                        }

                        $obj->user_id = $row->user->id;
                        $obj->user_name = substr($row->user->username,0,21);
                        $obj->image = $row->images->thumbnail->url;
                        $obj->created_time = humanTiming($row->created_time);
                        $obj->likes_count = $row->likes->count;
                        $obj->comments_count = $row->comments->count;
                        $obj->liked = false;

                        $result[] = $obj;
                    }
                    $response['data'] = $result;
                }
            }
        }

        echo json_encode($response);
    }


    public function followers($user_id)
    {
        $result = $this->model->getFollowers($user_id);
        pr($result); die();
    }

    public function followings($user_id)
    {
        $result = $this->model->getFollowings($user_id);
        pr($result); die();
    }

	public function feed()
	{		
		// Get the user data
		//getUserFeed($max = null, $min = null) {		
		$data['user_id'] = '';
		$data['user_self_id'] = $this->user_self_id;
        $max_id = '';
		if (!empty($this->input->get('max_id'))) {
			$max_id = $this->input->get('max_id');
		}
		
		$user_data = $this->instagram_api->getUserFeed($max_id);
		//pr($user_data);
		if ($user_data->meta->code == 200) {
			$pagination = $user_data->pagination;
			$data['next'] = ''; 
			$username = $this->session->userdata('instagram-username');	
			if(is_array($user_data->data)) {
				$data['tag'] = '';
				$data['recent_data'] = $user_data->data;	
				if(isset($user_data->pagination->next_max_id)){
					$data['next'] = $user_data->pagination->next_max_id;		
				}
				
				$self_username = $this->session->userdata('instagram-username');
				$self_fullname = $this->session->userdata('instagram-full-name');
				$data['meta_title'] = "@$self_username -  $self_fullname Instagram Photo | Sharetagram"; 
				$data['meta_description'] = "$self_fullname Instagram Photo feed";
				$data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";	
				
				if($this->input->get('more')==1){
					$this->load->view('user/recent_more',$data);			
				}
				else{
					$data['content'] = 'user/recent';
					$this->load->view('layout/dashboard_view',$data);			
				}
			}
		}
		else{
			$data['meta_title'] = '@'.ur(3).' Instagram Photo | Sharetagram'; 
			$data['meta_description'] = '@'.ur(3).' Instagram Photo feed';
			$data['meta_keywords'] = 'Instagram, IG, web, viewer, stats, photo, video, Facebook';
			
			$data['error'] = 'Sorry, an error occurred loading this content.<br>(Instagram could not be reached)';
			$data['content'] = 'layout/error_api_v';
			$this->load->view('layour/dashboard_view',$data);
		}	
	}
	
	public function recentlama()
    {
		// Get the user id
		$data['user_id'] = $user_id = $this->input->get('user_id');
		$data['user_self_id'] = $this->user_self_id;
		
		if(!$this->input->get('more')){
			$view = 'user/recent';
			$max_id = '';	
		}
		else if($this->input->get('more')==1){
			$view = 'user/recent_more';
			$max_id = $this->input->get('max_id');
		}			
		
		// instagram api lib getUserRecent
		$user_recent_data = $this->M->getUserRecent($user_id,$max_id);
		//pr($user_recent_data);		
		if($user_recent_data->meta->code == 200){
			if(isset($user_recent_data->pagination->next_max_id)){
				$data['next'] = $user_recent_data->pagination->next_max_id;		
			}			
			// get view : full or in frame / load ajax
			$data['recent_data'] = $user_recent_data->data;				
		}
		else{
			echo 'Sorry, an error occurred loading this content.<br>(Instagram could not be reached)';			
		}	
		
		$this->load->view($view,$data);
	}

	//post follow
	public function post_follow()
	{
		if ($this->input->get('id')) {
			$user_id = $this->input->get('id');
			if (session('instagram-user-id')) {
				$action = $this->input->get('action');
				$q = $this->instagram_api->modifyUserRelationship($user_id, $action);
			} else {
				echo "You Should Login";
			}
		} else {
			die('should exsist get id');
		}
	}
	
	function get_following_id($user_id)
	{
		// get info user self follow this user
		if($this->session->userdata('instagram-user-id')!=''){
			$q = $this->instagram_api->userRelationship($user_id);
			//pr($q);
			if($q){
				$outgoing_status = $q->data->outgoing_status;
				return $outgoing_status;	
			}
			return false;
		}
		return false;
	}

	function fol($type,$user_id=null){
        // Get the user followers and followings
        $cursor = '';
        if (!empty($this->input->get('cursor'))) {
            $cursor = $this->input->get('cursor');
        }

        if (ur(4) == 'followers') {
            $q = $this->M->getFollowers($user_id, $cursor);
            $meta = 'followers';
        } else if (ur(4) == 'followings') {
            $q = $this->M->getFollowings($user_id, $cursor);
            $meta = 'followings';
        }

        if (!$q) {
            redirect('user/private');
        }

        $data['query'] = $q->data;

        $data['cursor'] = '';
        if (isset($q->pagination->next_cursor)) {
            $data['cursor'] = $q->pagination->next_cursor;
        }

        if ($this->input->get('more') == 1) {
            $this->load->view('user/flower_more', $data);
        } else {
            $data['meta_title'] = "@$rec->username's $meta on Instagram  | Sharetagram";
            $data['meta_description'] = "@$rec->full_name's $meta on Instagram | Use Instagram online! Sharetagram is the Best Instagram Web Viewer!";
            $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";
            $data['content'] = 'user/flower';
            $this->load->view('layout/dashboard_view', $data);
        }
		$data['user_self_id'] = $user_self_id  = $this->user_self_id;					
		if($user_self_id!=''){
			if($user_id == $user_self_id){
				$user_id = $user_self_id;
			}			
		}else{
			echo 'Not Allowed';		
		}					
	}	 
	
	public function my_likes()
    {
		$data['user_self_id'] = $user_self_id  = $this->user_self_id;
		$data['tag'] = '';
		
		if($user_self_id!=''){
		
			if( $this->input->get('max_like_id')!='' ){
				$max_like_id = $this->input->get('max_like_id');
			}else{
				$max_like_id = '';
			}
			
			$q = $this->M->userMediaLiked($max_like_id);
			
			if( isset($q->pagination->next_max_like_id) ){
				$data['next'] = $q->pagination->next_max_like_id;
			}else{
				$data['next'] = '';
			}
			
			$data['tag_data'] = $q->data;
			
			$data['meta_title'] = "My Likes | Sharetagram"; 
			$data['meta_description'] = "My Likes | Use Instagram online! Sharetagram is the Best Instagram Web Viewer!";
			$data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";			
			
			
			$data['more'] = $this->input->get('more');
			// use view photo list by tag
			if( $this->input->get('more')==1 ){
				$this->load->view('tag/hashtag_more',$data);
			}else{					
				$data['content'] = 'tag/hashtag';				
				$this->load->view('layout/dashboard_view',$data);
			}
			
		}else{
			redirect(site_url());
		}
	}

    public function accountPrivate()
    {
        $data['meta_title'] = "Sharetagram - Instagram Web Viewer";
        $data['meta_description'] = "The best Instagram web viewer online, browse popular photos, tags, users.";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";
        $data['error'] = 'Oops... this account is private.';
        $data['content'] = 'layout/error_api_v';
        $this->load->view('layout/dashboard_view',$data);
    }
	
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
