<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;

class Likes extends CI_Controller
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

    public function isLiked()
    {
		$request = new Request();
	    $post = json_decode($request->getContent(), true);
		
        if ($post['action'] == 'unlike') {
            $query = $this->instagram->removeLike($post['media_id']);
        } elseif ($post['action'] == 'like') {
            $query = $this->instagram->postLike($post['media_id']);
        }		
		
        if ($query) {
            $response['data'] = ['success' => true];
        } else {
            $response['data'] = ['success' => false];
        }
        echo json_encode($response);
    }
}
