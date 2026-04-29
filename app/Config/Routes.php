<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route publique — aucun filtre
$routes->get('/', 'AuthController::form');
$routes->get('/login', 'AuthController::form');
$routes->get('/dashboard', 'NoteController::dashboard');
$routes->get('/notes/ajouter/(:num)', 'NoteController::ajouter/$1');
$routes->post('/notes/save/(:num)', 'NoteController::sauvegarder/$1');

// ======== test connexion ========
$routes->get('/test-db', 'TestDb::index');

// Routes pour les étudiants
$routes->group('etudiant', function($routes) {
    $routes->get('/', 'EtudiantController::index');
    $routes->get('create', 'EtudiantController::create');
    $routes->post('store', 'EtudiantController::store');
    $routes->get('edit/(:num)', 'EtudiantController::edit/$1');
    $routes->post('update/(:num)', 'EtudiantController::update/$1');
    $routes->delete('delete/(:num)', 'EtudiantController::delete/$1');
    $routes->get('show/(:num)', 'EtudiantController::show/$1');
    $routes->get('search', 'EtudiantController::search');
    $routes->get('filter/(:num)', 'EtudiantController::filter/$1');
});

// Routes pour les matières
$routes->group('matiere', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'MatiereController::index');
    $routes->get('create', 'MatiereController::create');
    $routes->post('store', 'MatiereController::store');
    $routes->get('edit/(:num)', 'MatiereController::edit/$1');
    $routes->post('update/(:num)', 'MatiereController::update/$1');
    $routes->delete('delete/(:num)', 'MatiereController::delete/$1');
    $routes->get('show/(:num)', 'MatiereController::show/$1');
    $routes->get('search', 'MatiereController::search');
    $routes->get('filter/(:num)', 'MatiereController::filter/$1');
});
