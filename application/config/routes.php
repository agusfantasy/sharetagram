<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['404_override'] = 'error/index404';

$route['api'] = 'error/instagramApi';

$route['default_controller'] = "site/index";

// routes for home
$route['home'] = "site/home";

// routes for popular
$route['popular'] = "popular/index";
$route['popular/more'] = "popular/more";

// routes for search
$route['search/(:any)'] = "search/q/$1";
$route['search'] = "search/index";

// routes for tag
$route['tag_more/(:any)'] = "tag/more/$1";
$route['tag/(:any)'] = "tag/index/$1";

//routes for item
$route['m/(:any)'] = "item/index/$1";
$route['m/(:any)/likes'] = "item/userLikes/$1";

// routes for user
$route['user/(:num)/(:any)'] = "user/index/$1/$2";
$route['user/recent/(:num)'] = "user/recent/$1";
$route['followers/(:num)'] = "user/followers/$1";
$route['followings/(:num)'] = "user/followings/$1";
$route['feed'] = "user/feed";
$route['my_likes'] = "user/my_likes";
$route['user/private'] = 'user/accountPrivate';

// routes for info
$route['about'] = "info/about";
$route['privacy'] = "info/privacy";
$route['tos'] = "info/tos";
$route['contact'] = "info/contact";
$route['contact_post'] = "info/contact_post";

// routes for admin
$route['admin'] = "admin/ig/index";

/* End of file routes.php */
/* Location: ./application/config/routes.php */