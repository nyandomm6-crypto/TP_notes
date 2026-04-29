<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route publique — aucun filtre
$routes->get('/', 'AuthController::form');
$routes->get('/dashboard', 'NoteController::dashboard');
$routes->get('/notes/ajouter/(:num)', 'NoteController::ajouter/$1');
$routes->post('/notes/save/(:num)', 'NoteController::sauvegarder/$1');


// $routes->post('/login', 'AuthController::login');
// $routes->get('/', 'BookController::index');

// Routes protégées — utilisateur connecté uniquement
// $routes->group('', ['filter' => 'auth'], function ($routes) {
//     $routes->get('/livre/(:num)', 'BookController::show/$1');
//     $routes->get('/livre/ajout', 'BookController::create');
//     $routes->post('/livre/store', 'BookController::store');
//     $routes->get('/livre/modifier/(:num)', 'BookController::edit/$1');
//     $routes->post('/livre/update/(:num)', 'BookController::update/$1');
//     // Routes prêt/retour
//     $routes->post('/livre/preter/(:num)', 'LoanController::borrow/$1');
//     $routes->post('/livre/retourner/(:num)', 'LoanController::returnBook/$1');
// });

// // Routes réservées à l'admin

// $routes->group('admin', ['filter' => 'role:admin'], function($routes) {
//     $routes->get('dashboard','Admin\DashboardController::index');
//     $routes->post('/livre/supprimer/(:num)', 'BookController::delete/$1');
//     $routes->get('utilisateurs','Admin\UserController::index');
// });

// // Routes accessibles à admin ET bibliothécaire
// $routes->group('gestion', ['filter' => 'role:admin,bibliothecaire'],
// function($routes) {
//     $routes->get('emprunts','Gestion\EmpruntController::index');
//     $routes->get('emprunts/retards','Gestion\EmpruntController::retards');
// });


// // ======== test connexion ========
// $routes->get('/test-db', 'TestDb::index');
