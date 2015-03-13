<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Model for handle list of photo/video in :
 * Popular, Tag, User Recent, User Self Feed, User Self Liked
 */
class InstagramPhotosModel extends InstagramModel
{
    public function __construct()
    {
        if (empty(session('ig-token'))) {
            $this->setToken(INSTAGRAM_TOKEN);
        }
    }

    /*
     * get All
     *
     * @param String $endpoint
     * @param String $auth
     * @param String $max_id
     * @param String $user_id
     * @param bool $auth
     *
     * @return mixed
     */
    public function getAll($endpoint, $max_id = null, $user_id = null, $auth = false)
    {
        if ($endpoint == 'popular') {
            $query = $this->getPopular();
        } elseif ($endpoint == 'tag') {
            $query = $this->getTag($max_id);
        } elseif ($endpoint == 'user_recent') {
            $query = $this->getUserRecent($user_id, $max_id);
        } elseif ($endpoint == 'user_self_feed') {
            $query = $this->getUserFeed($max_id);
        } elseif ($endpoint == 'user_self_liked') {
            $query = $this->getUserSelfLiked($max_id);
        }

        if (!$query) {
           return false;
        }

        $data['pagination'] =  $query->pagination;

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
            $obj->liked = $this->isLiked($row->id);
            if ($obj->liked) {
                $obj->like_colour = 'color:#c12e2a';
            }

            $result[] = $obj;
        }

        $data['data'] = $result;

        return $data;
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
