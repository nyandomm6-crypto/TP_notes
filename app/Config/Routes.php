<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route publique — aucun filtre
$routes->get('/', 'AuthController::form');
$routes->get('/login', 'AuthController::form');
$routes->get('/dashboard', 'NoteController::dashboard');
// $routes->get('/notes/ajouter/(:num)', 'NoteController::ajouter/$1');
// $routes->post('/notes/save/(:num)', 'NoteController::sauvegarder/$1');

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

// ============================================================
// NOTES - Module complet
// ============================================================
$routes->group('notes', function($routes) {
    // Liste des notes
    $routes->get('/', 'Notes::index');
    
    // AJOUT de notes pour un étudiant spécifique
    $routes->get('ajouter/(:num)', 'Notes::ajouter/$1');     // Formulaire
    $routes->post('save/(:num)', 'Notes::sauvegarder/$1');   // Enregistrement
    
    // Modification d'une note
    $routes->get('edit/(:num)', 'Notes::edit/$1');
    $routes->post('update/(:num)', 'Notes::update/$1');
    
    // Suppression
    $routes->delete('delete/(:num)', 'Notes::delete/$1');
    
    // Notes par étudiant
    $routes->get('etudiant/(:num)', 'Notes::parEtudiant/$1');
});

// ============================================================
// BULLETIN - Module complet
// ============================================================

$routes->group('bulletin', function($routes) {
    // Formulaire de sélection
    $routes->get('/', 'Bulletin::index');
    
    // Génération du bulletin (HTML)
    $routes->get('afficher', 'Bulletin::afficher');
    $routes->post('afficher', 'Bulletin::afficher');
    
    // Génération PDF
    $routes->get('pdf/(:num)/(:num)/(:any)', 'Bulletin::genererPDF/$1/$2/$3');
    $routes->post('pdf', 'Bulletin::genererPDF');
    
    // Génération rapide depuis la fiche étudiant
    $routes->get('generate/(:num)', 'Bulletin::generateForStudent/$1');
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
