<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index'); // guest bebas

$routes->get('/place/create', 'PlaceController::create', ['filter' => 'auth']); // form tambah tempat

$routes->post('/place/store', 'PlaceController::store', ['filter' => 'auth']); // simpan tempat baru

$routes->get('/place/edit/(:num)', 'PlaceController::edit/$1'); // form edit tempat

$routes->post('/place/update/(:num)', 'PlaceController::update/$1'); // update data tempat

$routes->get('/place/delete/(:num)', 'PlaceController::delete/$1'); // hapus tempat

$routes->get('/login', 'AuthController::login'); // halaman login

$routes->post('/process-login', 'AuthController::processLogin'); // proses login

$routes->get('/logout', 'AuthController::logout'); // logout & destroy session

$routes->get('/place/approve/(:num)', 'PlaceController::approve/$1', ['filter' => 'auth']); // approve tempat (admin)

$routes->get('/pending-places', 'PlaceController::pending', ['filter' => 'admin']); // list tempat pending (admin)

$routes->post('/place/review/(:num)', 'PlaceController::review/$1', ['filter' => 'auth']); // kirim review tempat

$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'admin']); // dashboard (admin) 

$routes->get('whatsapp/send/(:any)/(:any)', 'WhatsappController::send/$1/$2');


$routes->group('api', function ($routes) {

    $routes->get('places', 'Api\PlaceApi::index');

    $routes->get('places/(:num)', 'Api\PlaceApi::detail/$1');

    $routes->post('places', 'Api\PlaceApi::create');

});

$routes->get('/payment/(:num)', 'PaymentController::pay/$1', ['filter' => 'auth']);
$routes->post('/payment/notification', 'PaymentController::notification');
$routes->post('/payment/success', 'PaymentController::success');
$routes->get('payment/delete/(:num)', 'PaymentController::delete/$1', ['filter' => 'admin']);
