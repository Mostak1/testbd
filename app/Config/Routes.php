<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('admin/dashboard', 'Admin\DashboardController::index');

$routes->get('admin/subject', 'Admin\SubjectsController::index');
$routes->get('admin/subject/all', 'Admin\SubjectsController::all');
$routes->post('admin/subject/new', 'Admin\SubjectsController::create');
$routes->post('admin/subject/delete', 'Admin\SubjectsController::delete');

$routes->get('admin/boards', 'Admin\BoardsController::index');
$routes->get('admin/boards/all', 'Admin\BoardsController::all');
$routes->post('admin/boards/new', 'Admin\BoardsController::create');
$routes->post('admin/boards/delete', 'Admin\BoardsController::delete');

$routes->get('admin/districts', 'Admin\DistrictsController::index');
$routes->get('admin/districts/all', 'Admin\DistrictsController::all');
$routes->post('admin/districts/new', 'Admin\DistrictsController::create');
$routes->post('admin/districts/delete', 'Admin\DistrictsController::delete');


$routes->get('admin/thana', 'Admin\ThanaController::index');
$routes->get('admin/thana/all', 'Admin\ThanaController::all');
$routes->post('admin/thana/new', 'Admin\ThanaController::create');
$routes->post('admin/thana/delete', 'Admin\ThanaController::delete');


$routes->get('admin/institutes', 'Admin\InstitutesController::index');
$routes->get('admin/institutes/all', 'Admin\InstitutesController::all');
$routes->post('admin/institutes/new', 'Admin\InstitutesController::create');
$routes->post('admin/institutes/delete', 'Admin\InstitutesController::delete');

$routes->get('admin/exams', 'Admin\ExamsController::index');
$routes->get('admin/exams/all', 'Admin\ExamsController::all');
$routes->post('admin/exams/new', 'Admin\ExamsController::create');
$routes->post('admin/exams/delete', 'Admin\ExamsController::delete');

$routes->get('admin/users', 'Admin\UsersController::index');
$routes->get('admin/users/all', 'Admin\UsersController::all');
$routes->post('admin/users/new', 'Admin\UsersController::create');
$routes->post('admin/users/delete', 'Admin\UsersController::delete');

$routes->get('admin/questions', 'Admin\QuestionsController::index');
$routes->get('admin/questions/all', 'Admin\QuestionsController::all');
$routes->post('admin/questions/new', 'Admin\QuestionsController::create');
$routes->post('admin/questions/delete', 'Admin\QuestionsController::delete');

$routes->get('districts/(:num)', 'Admin\QuestionsController::districts/$1');
$routes->get('thana/(:num)', 'Admin\QuestionsController::thana/$1');
$routes->get('institutes/(:num)', 'Admin\QuestionsController::institutes/$1');


$routes->get('/', 'Home::index');
$routes->get('/registration', 'RegistrationController::index');

$routes->post('registration/store', 'RegistrationController::store');
$routes->get('/login', 'RegistrationController::login');
$routes->post('/login', 'RegistrationController::login');
$routes->get('/logout', 'RegistrationController::logout');
$routes->get('/shop', 'Admin\SubjectsController::store');



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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
