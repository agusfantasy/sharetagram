<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Emojione\Emojione;

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
            $data['caption'] = Emojione::unicodeToImage($media->data->caption->text);
        }

        $data['user'] = $media->data->user;

        $data['tags'] = $media->data->tags;
        $data['comments'] = $media->data->comments;
        $data['likes'] = $media->data->likes;
        $data['is_liked'] = $this->isLiked($media_id);

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

        echo json_encode($query);
    }

    public function comments($media_id)
    {
        $comments = $this->instagram_api->mediaComments($media_id);

        foreach ($comments->data as $row) {
            $obj = new stdClass();
            $obj->id = $row->id;
            $obj->created_time = humanTiming($row->created_time);
            $obj->text  = $row->text;
            $obj->from['id'] = $row->from->id;
            $obj->from['username'] = substr($row->from->username,0,21);
            $obj->from['profile_picture'] = $row->from->profile_picture;

            $response[] = $obj;
        }

        echo json_encode($response);
    }

    private function isLiked($media_id)
    {
        if (empty(session('ig-token'))) return false;

        $liked = $this->instagram->isLiked(session('ig-id'), $media_id);
        if (!$liked) {
            return false;
        }
        return true;
    }
}
