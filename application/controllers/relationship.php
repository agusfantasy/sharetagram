<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('InstagramModel','model');\
        if (empty(session('instagram-token')) {
            $token = instagram_token();
        } else {
            $token = session('instagram-token');
        }

        $this->model->setToken(instagram_token());
    }

    public function like()
    {

    }

    public function like()
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

    public function unlike()
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