<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserCollection extends CI_Controller
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
        $result = $this->getAll(get('endpoint'), get('user_id'), get('next_cursor'));
        echo json_encode($result);
    }

    /* get All
     * @param String $endpoint, $auth, $max_id, $user_id;
     * @return mixed
     */
    public function getAll($endpoint, $user_id, $cursor = null)
    {
        if ($endpoint == 'followers') {
            $query = $this->instagram->getFollowers($user_id, $cursor);
        } elseif ($endpoint == 'followings') {
            $query = $this->instagram->getFollowings($user_id, $cursor);
        }

        if (!$query) {
            return false;
        }

        if (property_exists($query ,'code')) {
            $response['code'] = $query->code;
        } else {
            $response['code'] = $query->meta->code;
        }

        if (property_exists($query->pagination, 'next_cursor')) {
            $response['next_cursor'] =  $query->pagination->next_cursor;
        } else {
            $response['next_cursor'] = '';
        }

        $response['data'] = $this->collection($query->data);

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
            $obj->username = substr($row->username,0,21);
            $obj->profile_picture = $row->profile_picture;

            $result[] = $obj;
        }
        return $result;
    }
}
