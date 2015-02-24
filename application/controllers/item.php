<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mod_instagram', 'M');
    }

    public function index($media_id)
    {
        $media = $this->M->getMedia($media_id);

        if (!$media) {
            redirect('api?url=m/'.urldecode($media_id));
        }

        $likes_data = $media->data->likes->data;

        $data['tags'] = $media->data->tags;
        $data['media_id'] = $media_id;
        $data['comments_count'] = $media->data->comments->count;
        $data['comments_data'] = $media->data->comments->data;
        $data['created_time'] = '';
        $data['likes_count'] = $media->data->likes->count;
        $data['likes_data'] = $likes_data;

        if ($media->data->type == 'image') {
            $data['img_video'] = "<img class='img-responsive' src='" . $media->data->images->standard_resolution->url . "'>";
        } else {
            $data['img_video'] = "<video controls>
                        <source src='" . $media->data->videos->standard_resolution->url . "' type='video/mp4'>Your browser does not support the video tag.
                    </video>";
        }

        $data['caption'] = '';
        if ($media->data->caption !== null) {
            $data['caption'] = $media->data->caption->text;
        }

        /* User */
        // Get User item data
        $data['user'] = $user_data = $media->data->user;
        $data['username'] = $user_data->username;
        $data['user_fullname'] = $user_data->full_name;
        $data['user_id'] = $user_data->id;

        $data['user_pp'] = $user_data->profile_picture;

        $data['user_self_name'] = '';
        if (session('instagram-user-id')) {
            $data['user_self_name'] = session('instagram-username');
        }

        $data['meta_title'] = "Instagram Photo by @$user_data->username ($user_data->full_name) | Sharetagram";
        $data['meta_description'] = "Discover @$user_data->username - $user_data->full_name Instagram photo. See likes and comments. Post a comment with Facebook. Share it with friends.";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";

        $data['content'] = 'item/index';

        $this->load->view('layout/dashboard_view', $data);
    }

    public function getUserLikes()
    {
        $media_id = $this->input->get('media_id');
        $query = $this->M->getMediaUserLikes($media_id);

        echo json_encode($query->data);
    }

}