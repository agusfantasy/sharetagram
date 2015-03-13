<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Likes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('InstagramModel','instagram');
    }

    public function isLiked()
    {
        if (post('action')=='unlike') {
            $query = $this->instagram->removeLike(post('media_id'));
        } elseif (post('action')=='like')
            $query = $this->instagram->postLike(post('media_id'));
        }

        if ($query->meta->code == 200) {
            $response['data'] = ['success' => true];
        } else {
            $response['data'] = ['success' => false];
        }
        echo json_encode($response);
    }
}
