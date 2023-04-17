<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'authentication/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


	$route['privacy-policy'] 		= 'welcome/privacy_policy';   

/*admin panel*/

				
		/*Authentication*/
			$route['admin'] 		= 'authentication/login';   
			$route['login'] 		= 'authentication/login';
			$route['do-login'] 		= 'authentication/doLogin'; 
			$route['logout'] 		= 'authentication/logout';

			/*main page admin*/
			$route['main'] 				= 'welcome';   

		/*Blog*/
		$route['blog'] 							= 'master/blog_master';   
		$route['blogs'] 						= 'master/blog_master';
		$route['save-blog'] 					= 'master/blog_master/save';
		$route['blog-list'] 					= 'master/blog_master/dt_list';  
		$route['blog-delete/(:num)'] 			= 'master/blog_master/delete_blog/$1';   
		$route['blog-form/(:num)'] 				= 'master/blog_master/loadForm/$1';

		/*Deparrtment*/
		$route['department'] 							= 'master/department_master';   
		$route['departments'] 							= 'master/department_master';
		$route['save-department'] 						= 'master/department_master/save';
		$route['department-list'] 						= 'master/department_master/dt_list';  
		$route['department-delete/(:num)'] 				= 'master/department_master/delete_department/$1';   
		$route['department-form/(:num)'] 				= 'master/department_master/loadForm/$1';

		/*pricelist*/
		$route['pricelist'] 							= 'master/pricelist_master';   
		$route['pricelists'] 							= 'master/pricelist_master';
		$route['save-pricelist'] 						= 'master/pricelist_master/save';
		$route['pricelist-list'] 						= 'master/pricelist_master/dt_list';  
		$route['pricelist-delete/(:num)'] 				= 'master/pricelist_master/delete_pricelist/$1';   
		$route['pricelist-form/(:num)'] 				= 'master/pricelist_master/loadForm/$1';

		/*Blog*/
		$route['gallery'] 							= 'master/gallery_master';   
		$route['gallerys'] 						= 'master/gallery_master';
		$route['save-gallery'] 					= 'master/gallery_master/save';
		$route['gallery-list'] 					= 'master/gallery_master/dt_list';  
		$route['gallery-delete/(:num)'] 			= 'master/gallery_master/delete_gallery/$1';   
		$route['gallery-form/(:num)'] 				= 'master/gallery_master/loadForm/$1';


        /*App User*/
		$route['app-user'] 							= 'master/appusers_master';   
		$route['appuser'] 							= 'master/appusers_master';   
		$route['appusers'] 							= 'master/appusers_master';
		$route['save-appusers'] 						= 'master/appusers_master/save';
		$route['appusers-list'] 						= 'master/appusers_master/dt_list';  
		$route['appusers-delete/(:num)'] 				= 'master/appusers_master/delete_appusers/$1';   
		$route['appusers-form/(:num)'] 				= 'master/appusers_master/loadForm/$1';

		/*Migration*/
		$route['migration/gallery/(:any)'] 				= 'migration/gallery/$1';
		$route['migration/pricelist/(:any)'] 			= 'migration/pricelist/$1';
		$route['migration/blog/(:any)'] 				= 'migration/blog/$1';
		$route['migration/thumb/(:any)'] 				= 'migration/thumb_generation/$1';

		/*General*/
		$route['profile']   							=	'dashboard/general/profile';

		/*Api*/
		$route['login-api']   							=	'api/api/login';
		$route['pricelist-api']   						=	'api/api/pricelist_api';
		$route['blog-api']   							=	'api/api/blog_api';
		$route['galleries-api']   						=	'api/api/galleries_api';

		$route['department-api']   							=	'api/api/dept_api';


