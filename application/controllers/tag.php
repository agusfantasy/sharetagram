<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('InstagramModel','instagram');
        $this->instagram->setToken(instagram_token());
    }

    /*	get photos/videos by tag */
    public function index()
    {
        $data['tag'] = $tag = ur(2);

        $data['meta_title'] = "Instagram photos for tag #$tag | Sharetagram";
        $data['meta_description'] = "Browse all Instagram photos tagged with #$tag. View likes and comments.";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook, hashtag $tag";
        $data['meta_image'] = base_url() . 'images/logo_500.png';

        $data['title'] = "#$tag";

        $data['content'] = 'tag/tag_index';
        $this->load->view('layout/dashboard_view', $data);
    }

    public function more($tag)
    {
        $query = $this->instagram->getTag($tag, get('max_id'));

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
}

