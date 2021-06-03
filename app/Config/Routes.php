<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('admin', function ($routes) {
	// routes for admin auth
	$routes->add('/', 'Admin\Auth::login');
	$routes->add('login', 'Admin\Auth::login');
	$routes->add('logout', 'Admin\Auth::logout', ['filter' => 'admin_auth']);
	// routes for dashboard
	$routes->add('home', 'Admin\Home::index', ['filter' => 'admin_auth']);
	$routes->add('dashboard', 'Admin\Home::index', ['filter' => 'admin_auth']);
	// routes for form groups
	$routes->add('form/groups', 'Admin\FormGroups::index', ['as' => 'form_groups', 'filter' => 'admin_auth']);
	$routes->add('form/groups/add', 'Admin\FormGroups::add', ['as' => 'form_groups_add', 'filter' => 'admin_auth']);
	$routes->add('form/groups/edit/(:num)', 'Admin\FormGroups::edit/$1', ['as' => 'form_groups_edit', 'filter' => 'admin_auth']);
	$routes->add('form/groups/disable/(:num)', 'Admin\FormGroups::disable/$1', ['as' => 'form_groups_disable', 'filter' => 'admin_auth']);
	// routes for form fields
	$routes->add('form/fields', 'Admin\FormFields::index', ['as' => 'form_fields', 'filter' => 'admin_auth']);
	$routes->add('form/fields/add', 'Admin\FormFields::add', ['as' => 'form_fields_add', 'filter' => 'admin_auth']);
	$routes->add('form/fields/edit/(:num)', 'Admin\FormFields::edit/$1', ['as' => 'form_fields_edit', 'filter' => 'admin_auth']);
	$routes->add('form/fields/disable/(:num)', 'Admin\FormFields::disable/$1', ['as' => 'form_fields_disable', 'filter' => 'admin_auth']);
	// routes for form fields settings
	$routes->add('form/group/settings/(:num)', 'Admin\FormFieldSettings::group/$1', ['as' => 'form_field_settings', 'filter' => 'admin_auth']);
	$routes->add('form/group/field/add/(:num)', 'Admin\FormFieldSettings::add/$1', ['as' => 'form_field_settings_add', 'filter' => 'admin_auth']);
	$routes->add('form/group/field/settings/(:num)/(:num)', 'Admin\FormFieldSettings::edit/$1/$2', ['as' => 'form_field_settings_edit', 'filter' => 'admin_auth']);
	$routes->add('form/group/field/disable/(:num)/(:num)', 'Admin\FormFieldSettings::disable/$1/$2', ['as' => 'form_field_settings_disable', 'filter' => 'admin_auth']);
	// routes for content groups
	$routes->add('content/groups', 'Admin\ContentGroups::index', ['as' => 'content_groups', 'filter' => 'admin_auth']);
	$routes->add('content/groups/add', 'Admin\ContentGroups::add', ['as' => 'content_groups_add', 'filter' => 'admin_auth']);
	$routes->add('content/groups/edit/(:num)', 'Admin\ContentGroups::edit/$1', ['as' => 'content_groups_edit', 'filter' => 'admin_auth']);
	$routes->add('content/groups/disable/(:num)', 'Admin\ContentGroups::disable/$1', ['as' => 'content_groups_disable', 'filter' => 'admin_auth']);
	// routes for contents
	$routes->add('content/(:num)/(:any)', 'Admin\Contents::list/$1/$2', ['as' => 'contents', 'filter' => 'admin_auth']);
	$routes->add('content/add/(:num)/(:any)', 'Admin\Contents::add/$1/$2', ['as' => 'contents_add', 'filter' => 'admin_auth']);
	$routes->add('content/add/(:num)/(:any)/(:any)', 'Admin\Contents::add/$1/$2/$3', ['as' => 'contents_add_custom_form', 'filter' => 'admin_auth']);
	$routes->add('content/edit/(:any)/(:any)', 'Admin\Contents::edit/$1/$2', ['as' => 'contents_edit', 'filter' => 'admin_auth']);
	$routes->add('content/edit/(:any)/(:any)/(:any)', 'Admin\Contents::edit/$1/$2/$3', ['as' => 'contents_edit_custom_form', 'filter' => 'admin_auth']);
	$routes->add('content/disable/(:num)/(:num)', 'Admin\Contents::disable/$1/$2', ['as' => 'contents_disable', 'filter' => 'admin_auth']);
	$routes->add('content/file/edit/(:num)/(:num)/(:num)/(:any)', 'Admin\Contents::file_edit/$1/$2/$3/$4', ['as' => 'contents_file_edit', 'filter' => 'admin_auth']);
	$routes->add('content/file/delete/(:num)/(:num)/(:num)/(:any)', 'Admin\Contents::delete_file/$1/$2/$3/$4', ['as' => 'contents_file_delete', 'filter' => 'admin_auth']);
	// routes for profile
	$routes->add('profile', 'Admin\Profile::index', ['as' => 'profile', 'filter' => 'admin_auth']);
	$routes->add('profile/change_password', 'Admin\Profile::change_password', ['as' => 'change_password', 'filter' => 'admin_auth']);
	// routes for settings
	$routes->add('settings', 'Admin\Settings::index', ['as' => 'settings', 'filter' => 'admin_auth']);
});

/**
 * error pages routing
 */
$routes->add('error/404', 'Errors\show_404', ['as' => 'show_404']);
$routes->add('error/403', 'Errors\show_403', ['as' => 'show_403']);


/** routing web pages */
$routes->add('/', 'Web\Home::index');
$routes->add('/home', 'Web\Home::index', ['as' => 'home']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
