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

        $data['endpoint'] = 'user_recent';
        $data['param'] = $id;

        $data['content'] = 'user/user';
        $this->load->view('layout/dashboard_view', $data);

    }

	public function feed()
	{
        $data['meta_title'] = "@". session('ig_username') ."Instagram Photo | Sharetagram";
        $data['meta_description'] = session('ig_username') ."Instagram Photo feed";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";

        $data['endpoint'] = 'user_self_feed';

        $data['content'] = 'view_media';
        $this->load->view('layout/dashboard_view', $data);
	}

    public function liked()
    {
        $data['meta_title'] = "Liked Media | Sharetagram";
        $data['meta_description'] = "Browse All Instagram on the web, like, comment, follow and much more in Sharetagram.com";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";

        $data['endpoint'] = 'user_self_liked';
        $data['param'] = session('ig_id');

        $data['content'] = 'view_media';
        $this->load->view('layout/dashboard_view', $data);
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
