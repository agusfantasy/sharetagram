<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InstagramModel extends CI_Model
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
		if( $media_likes->meta->code == 200 ) {
			if(is_array($media_likes->data) && count($media_likes->data) > 0){
                return $media_likes;
			}
		}
		return false;
	}
	
	public function getFollowers($user_id, $cursor = null)
    {
        $query = $this->instagram_api->userFollowedBy($user_id,$cursor);
        if (!$query || property_exists($query, 'code')) {
            return false;
        }
        return $query;
	}
	
	public function getFollowings($user_id, $cursor = null)
    {
        $query = $this->instagram_api->userFollows($user_id,$cursor);

        if (!$query || property_exists($query, 'code')) {
            return false;
        }

		if ($query->meta->code == 200) {
		    return $query;
	    }
	}
	
	function checkSelfLike($mid){
		if($this->checkLoginStatus() && $this->getLikeListId($mid)){
			if( in_array($this->user_self_id,$this->getLikeListId($mid)) ){
				return TRUE;
			}else{
				return FALSE;
			}	
		}
		return FALSE;
	}
	
	function userMediaLiked($max_like_id){
		if($this->user_self_id!=''){
			$q = $this->instagram_api->userMediaLiked($max_like_id);
			if($q->meta->code==200){
				return $q;
			}			
		}
		return FALSE;	
	}
	
	public function getTag($tag, $max_id = null, $min_id = null)
    {
        $query = $this->instagram_api->tagsRecent($tag, $max_id, $min_id);

        if (!$query) {
            return false;
        }

        if (property_exists($query, 'code')) {
            return $query->code;
        }

        if ($query->meta->code === 200) {
            return $query;
        }

        return false;

	}

    /*
     * Get User
     * @param int $id
     * @return mixed object|bool
     */
	public function getUser($id)
    {
        $query = $this->instagram_api->getUser($id);

        if (!$query || property_exists($query, 'code')) {
            return false;
        }

		return $query;
	}
	
	public function getMedia($id)
    {
        $query = $this->instagram_api->getMedia($id);

        if (!$query || property_exists($query, 'code')) {
            return false;
        }

        return $query;
	}

    public function tagSearch($keyword)
    {
        $keyword = urldecode($keyword) ;
        $result = $this->instagram_api->tagsSearch($keyword);
        if(!$result){
            return false;
        }
        if ($result->meta->code === 200) {
            return $result;
        }
        return false;
    }

    public function userSearch($keyword)
    {
        $keyword = urldecode($keyword) ;
        $result = $this->instagram_api->userSearch($keyword);
        if(!$result){
            return false;
        }
        if ($result->meta->code === 200) {
            return $result;
        }
        return false;
    }

    public function getUserRecent($user_id, $max_id)
    {
        $query  = $this->instagram_api->getUserRecent($user_id, $max_id);

        if (!$query || property_exists($query, 'code')) {
            return false;
        }

        if($query->meta->code==200){
            return $query;
        }

        return false;
    }



}
?>