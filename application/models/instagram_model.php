<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instagram_model extends CI_Model
{
    private $token;
    private $user_self_id;

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();

    }

    public function setToken($token)
    {
        $this->instagram_api->access_token = $token;
        $this->token = $token;
        return true;
    }

    public function getToken()
    {
        if (! is_null($this->token) ) {
            return $this->token;
        }
        return false;
    }

    public function login()
    {
        return $this->instagram_api->instagramLogin();
    }

    public function auth($code)
    {
        return $this->instagram_api->authorize($code);
    }

    /**
     * @return bool | mixed object
     */
    function getPopular()
    {
        $query = $this->instagram_api->getPopularMedia();

        if (!$query || property_exists($query, 'code')) {
            return false;
        }

        if ($query->meta->code == 200) {
            return $query;
        }

        return false;
	}
	
	// get Tags list search result
	// parameter tag
	function getTagList($p){
		$q = $this->instagram_api->tagsSearch($p);	
		if( $q->meta->code==200 ){
			if( is_array($q->data) ){
				return $q->data;
			}
		}else{			
			return 'api';
		}
		return FALSE;
	}
	
	public function getMediaUserLikes($media_id)
    {
		$media_likes = $this->instagram_api->mediaLikes($media_id);
		if ($media_likes->meta->code == 200) {
			if(is_array($media_likes->data) && count($media_likes->data) > 0){
                return $media_likes->data;
			}
		}
		return false;
	}
	
	public function getFollowers($user_id, $cursor = null)
    {
        $query = $this->instagram_api->userFollowedBy($user_id,$cursor);
        if (!$query) {
            return false;
        }
        return $query;
	}
	
	public function getFollowings($user_id, $cursor = null)
    {
        $query = $this->instagram_api->userFollows($user_id,$cursor);

        if (!$query) {
            return false;
        }
        return $query;
	}

    public function isLiked($self_id, $media_id)
    {
        $likes = $this->getMediaUserLikes($media_id);
        if($likes) {
            $likeIds = [];
            foreach($likes as $like) {
                $likeIds[] = $like->id;
            }

            if(in_array($self_id, $likeIds)){
                return true;
            }
            return false;
        }

        return false;
    }
	
	public function getUserSelfLiked($max_like_id)
    {
	    $query = $this->instagram_api->userMediaLiked($max_like_id);
        if (!$query && property_exists($query, 'code') && $q->meta->code !== 200) {
            return false;
        }
		return $query;
	}
	
	public function getTag($tag, $max_id = null, $min_id = null)
    {
        $query = $this->instagram_api->tagsRecent($tag, $max_id, $min_id);

        if (!$query) {
            return false;
        }
        return $query;
	}

    /*
     * Get User
     * @param int $id
     * @return mixed object|bool
     */
	public function getUser($id)
    {
        $query = $this->instagram_api->getUser($id);

        if (!$query) {
            return false;
        }

		return $query;
	}
	
	public function getMedia($id)
    {
        $query = $this->instagram_api->getMedia($id);

        if (!$query) {
            return false;
        }

        return $query;
	}

    public function tagSearch($keyword)
    {
        $result = $this->instagram_api->tagsSearch($keyword);
        if(!$result){
            return false;
        }
		
        return $result;
    }

    public function userSearch($keyword)
    {
        $result = $this->instagram_api->userSearch($keyword);
        if(!$result){
            return false;
        }
        return $result;
    }

    public function getUserRecent($user_id, $max_id)
    {
        $query  = $this->instagram_api->getUserRecent($user_id, $max_id);
		
        if (!$query) {
            return false;
        }
       
		return $query;       
    }

    public function getUserFeed($max_id)
    {
        $query  = $this->instagram_api->getUserFeed($max_id);

        if (!$query) {
            return false;
        }

        return $query;
    }

    public function getMediaComments()
    {
        $query = $this->instagram_api->mediaComments($media_id);
        if (!$query || property_exists($query, 'code')) {
            return false;
        }
        return $query;
    }
	
	public function postLike($media_id) {
		$query = $this->instagram_api->postLike($media_id);
		if ($query->meta->code == 200) {
			return true;
		}
		return false;
	}
	
	public function removeLike($media_id) {
		$query = $this->instagram_api->removeLike($media_id);
		if ($query->meta->code == 200) {
			return true;
		}
		return false;
	}
	
	public function getRelationship($user_id){
		$query = $this->instagram_api->userRelationship($user_id);

		if($query){
			$outgoing_status = $query->data->outgoing_status;
			return $outgoing_status;
		}
		return false;
	}
	
	public function modifyRelationship($user_id, $action){
		$query = $this->instagram_api->modifyUserRelationship($user_id, $action);

		if (!$query) {
			return false;
		}
		
		if($query->meta->code==200){
			$outgoing_status = $query->data->outgoing_status;
			return $outgoing_status;
		}
		return false;
	}
}
