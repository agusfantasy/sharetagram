<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('InstagramModel', 'instagram');
        $this->instagram->setToken(instagram_token());
    }

    public function index($media_id)
    {
        $media = $this->instagram->getMedia($media_id);

        if (!$media) {
            redirect('api?url=m/'.urldecode($media_id));
        }

        $data['media'] = $media;

        $data['type'] = $media->data->type;

        $data['user'] = $media->data->location;

        $data['created_time'] = date('g.ia j.M.Y', $media->data->created_time);

        $data['location'] = $media->data->location;

        $data['caption'] = "";
        if (! is_null($media->data->caption) ) {
            $data['caption'] = $media->data->caption->text;
        }

        $data['user'] = $media->data->user;

        $data['tags'] = $media->data->tags;
        $data['comments'] = $media->data->comments;
        $data['likes'] = $media->data->likes;

        $data['meta_title'] = "Instagram Photo by @{$data['user']->username} ({$data['user']->full_name}) | Sharetagram";

        if (empty($data['caption'])) {
            $data['meta_description'] = "Discover @{$data['user']->username} - {$data['user']->full_name} Instagram photo.
            See likes and comments. Post a comment with Facebook. Share it with friends.";
        } else {
            $data['meta_description']  = substr($data['caption'], 0, 150);
        }

        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";

        $data['content'] = 'item/item_index';

        $this->load->view('layout/dashboard_view', $data);
    }

    public function userLikes($media_id)
    {
        $query = $this->instagram->getMediaUserLikes($media_id);

        echo json_encode($query->data);
    }

}