<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Emojione\Emojione;

class User extends CI_Controller
{
	public function __construct()
    {
		parent::__construct();

        $this->load->model('instagram_model','instagram');
		$this->load->model('mod_user','user');
		
		if (empty(session('ig_token'))) {
	        $this->instagram->setToken($this->user->getTokenUsed());
		} else {
			$this->instagram->setToken(session('ig_token'));
		}
	}

    public function index($id)
    {
        $user = $this->instagram->getUser($id);
		
		if (!$user){
            redirect('api');
        }

		if (property_exists($user ,'code')) {
			if ($user->code === 429) {
				redirect('limit');
			}
		}
		
        if ($user->meta->code === 400) {
            redirect('user/private');
        }

        $data['user'] = $user;
		
		$relationship = $this->instagram->getRelationship($user->data->id);
        if (!empty(session('ig_id')) && $relationship) {
            if ($relationship == 'follows') {
                $data['rel_status'] = 'following';
                $data['rel_class'] = 'btn-success';
            } else if ($relationship == 'requested') {
                $data['rel_status'] = 'requested';
                $data['rel_class'] = 'btn-warning';
            } else {
                $data['rel_status'] = 'follow';
                $data['rel_class'] = 'btn-primary';
            }
        } else {
            $data['rel_status'] = 'follow';
            $data['rel_class'] = 'btn-primary';
        }

        $data['meta_title'] = "@{$user->data->username} -  {$user->data->full_name} on Instagram | Sharetagram";
        $data['meta_description'] = "{$user->data->full_name} Instagram Photo feed";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";

        $data['content'] = 'user/user';
        $this->load->view('layout/dashboard_view', $data);

    }

    public function recent($user_id)
    {
        $max_id = get('max_id');

        $query = $this->instagram->getUserRecent($user_id, $max_id);

        if (!$query) {
            $response['alert'] = 'fail';
        } else {
			if (property_exists($query ,'code')) {
				if ($query->code === 429) {
					$response['alert'] = 'limit';
				}
			} else {
                $response['alert'] = 'success';
                $response['code'] = $query->meta->code;
				$response['self_id'] = session('ig_id'); 
				
                $response['max_id'] = '';
                if (property_exists($query->pagination,'next_max_id')) {
                    $response['max_id'] =  $query->pagination->next_max_id;
                }

                $response['data'] = '';
                if (!empty($query->data)) {

                    $response['count_per_load'] = count($query->data);

                    foreach ($query->data as $k => $row) {
                        $obj = new stdClass();
                        $obj->id = $row->id;
                        $obj->type = $row->type;

                        if ($obj->type == 'video') {
                            $obj->has_video = 'block';
                        } else {
                            $obj->has_video = 'none';
                        }

                        $obj->user_id = $row->user->id;
                        $obj->user_name = substr($row->user->username, 0, 21);
                        $obj->image = $row->images->thumbnail->url;
                        $obj->created_time = humanTiming($row->created_time);
                        $obj->likes_count = $row->likes->count;
                        $obj->comments_count = $row->comments->count;
                        $obj->liked = $this->instagram->isLiked(session('ig_id'), $row->id);						
                        $obj->like_class = '';
                        if ($obj->liked) {
                            $obj->like_class = 'liked';
                        }

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
        $query = $this->instagram->getFollowers($user_id, get('next_cursor'));
		
		if (property_exists($query ,'code')) {
			if ($query->code === 429) {
				$response['alert'] = 'limit';
			}
		} else {
			$response['next_cursor'] = '';
			if (property_exists($query->pagination,'next_cursor')) {
				$response['next_cursor'] =  $query->pagination->next_cursor;
			}

			$response['count_per_load'] = count($query->data);
			$response['data'] = $query->data;
		}

        echo json_encode($response);
    }

    public function followings($user_id)
    {
        $query = $this->instagram->getFollowings($user_id, get('next_cursor'));
		
		if (property_exists($query ,'code')) {
			if ($query->code === 429) {
				$response['alert'] = 'limit';
			}
		} else {
			$response['next_cursor'] = '';
			if (property_exists($query->pagination,'next_cursor')) {
				$response['next_cursor'] =  $query->pagination->next_cursor;
			}

			$response['count_per_load'] = count($query->data);
			$response['data'] = $query->data;
		}

        echo json_encode($response);
    }

	public function feed($max_id)
	{
		$feed = $this->instagram->getUserFeed($max_id);

        $data['meta_title'] = "@{session('ig-username')} - {session('ig-fullname')} Instagram Photo | Sharetagram";
        $data['meta_description'] = "{session('ig-fullname')} Instagram Photo feed";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";
	}
	
	public function my_likes($max_like_id)
    {
		$query = $this->instagram->userMediaLiked($max_like_id);

        if (!$query) {
            $response['alert'] = 'fail';
        } else {
            if ($query ===  429) {
                $response['alert'] = $query;
            } else {
                $response['alert'] = 'success';
                $response['code'] = $query->meta->code;
                $response['pagination'] =  $query->pagination;

                foreach ($query->data as $k => $row) {
                    $obj = new stdClass();
                    $obj->id = $row->id;
                    $obj->type = $row->type;

                    if ($obj->type == 'video') {
                        $obj->has_video =  'block';
                    } else {
                        $obj->has_video = 'none';
                    }

                    $obj->user_id = $row->user->id;
                    $obj->user_name = substr($row->user->username,0,21);
                    $obj->image = $row->images->thumbnail->url;
                    $obj->created_time = humanTiming($row->created_time);
                    $obj->likes_count = $row->likes->count;
                    $obj->comments_count = $row->comments->count;

                    $result[] = $obj;
                }
                $response['data'] = $result;
            }
        }

        echo json_encode($response);
	}

	public function postFollow()
	{		
		$result = $this->instagram->modifyRelationship(post('user_id'), post('action'));
		echo json_encode($result);
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
