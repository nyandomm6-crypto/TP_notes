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
