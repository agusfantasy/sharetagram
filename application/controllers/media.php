<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('instagram_model', 'instagram');
        $this->load->model('mod_user','user');

        if (empty(session('ig_token'))) {
            $this->instagram->setToken($this->user->getTokenUsed());
        } else {
            $this->instagram->setToken(session('ig_token'));
        }
    }

    public function index()
    {
        $result = $this->getAll(get('endpoint'), get('param'), get('max_id'));
        echo json_encode($result);
    }

    /*
     * get All
     * @param String $endpoint
     * @param String $param : [tag_value], [user_id]
     * @param $max_id : pagination
     * @return mixed
     */
    public function getAll($endpoint, $param = null, $max_id = null)
    {
        if ($endpoint == 'popular') {
            $query = $this->instagram->getPopular();
            $view_user = true;
        } elseif ($endpoint == 'tag') {
            $query = $this->instagram->getTag($param, $max_id);
            $view_user = true;
        } elseif ($endpoint == 'user_recent') {
            $query = $this->instagram->getUserRecent($param, $max_id);
            $view_user = false;
        } elseif ($endpoint == 'user_self_feed') {
            $query = $this->instagram->getUserFeed($max_id);
            $view_user = false;
        } elseif ($endpoint == 'user_self_liked') {
            $query = $this->instagram->getUserSelfLiked($max_id);
            $view_user = false;
        }

        if (!$query) {
            return false;
        }

        if (property_exists($query ,'code')) {
            $response['code'] = $query->code;
        } else {
            $response['code'] = $query->meta->code;
            if ($query->meta->code !== 400) {
                $response['view_user'] = $view_user;

                $response['max_id'] = "";
                if (isset($query->pagination) && property_exists($query->pagination,'next_max_id')) {
                    $response['max_id'] =  $query->pagination->next_max_id;
                }

                $response['data'] = $this->collection($query->data);
            }
        }

        return $response;
    }

    private function isLiked($media_id)
    {
        if (empty(session('ig_token'))) return false;

        $liked = $this->instagram->isLiked(session('ig_id'), $media_id);
        if (!$liked) {
            return false;
        }
        return true;
    }

    private function collection($data)
    {
        foreach ($data as $k => $row) {
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
            $obj->liked = $this->isLiked($row->id);

            if ($obj->liked) {
                $obj->like_colour = 'color:#c12e2a';
            }

            $result[] = $obj;
        }
        return $result;
    }
}
