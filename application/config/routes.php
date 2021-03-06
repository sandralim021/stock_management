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
$route['default_controller'] = 'user';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//Users
$route['login/index'] = 'user/index';
$route['login'] = 'user/login';
$route['logout'] = 'user/logout';
$route['profile'] = 'user/profile';
$route['profile/update_profile/(:any)'] = 'user/update_profile/$1';
//Brands
$route['brands'] = 'brands/index';
$route['brands/insert'] = 'brands/insert';
$route['brands/fetch'] = 'brands/fetch';
$route['brands/delete'] = 'brands/delete/$1';
$route['brands/edit/(:any)'] = 'brands/edit/$1';
$route['brands/update/(:any)'] = 'brands/update/$1';
//Categories
$route['categories'] = 'categories/index';
$route['categories/insert'] = 'categories/insert';
$route['categories/fetch'] = 'categories/fetch';
$route['categories/delete'] = 'categories/delete/$1';
$route['categories/edit/(:any)'] = 'categories/edit/$1';
$route['categories/update/(:any)'] = 'categories/update/$1';
//Products
$route['products'] = 'products/index';
$route['products/fetch'] = 'products/fetch';
$route['products/insert'] = 'products/insert';
$route['products/delete'] = 'products/delete/$1';
$route['products/edit/(:any)'] = 'products/edit/$1';
$route['products/update/(:any)'] = 'products/update/$1';
//Add Order
$route['orders/add_order'] = 'orders/add_order';
$route['orders/insert_order'] = 'orders/insert_order';
$route['orders/qty_price/(:any)'] = 'orders/qty_price/$1';
//Manage Order
$route['orders/manage_orders'] = 'orders/manage_orders';
$route['orders/fetch_orders'] = 'orders/fetch_orders';
$route['orders/edit_payment/(:any)'] = 'orders/edit_payment/$1';
$route['orders/update_payment/(:any)'] = 'orders/update_payment/$1';
$route['orders/invoice/(:any)'] = 'orders/invoice/$1';
//Reports
$route['reports'] = 'reports/index';