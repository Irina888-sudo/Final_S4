<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// PAGE D'ACCUEIL
$routes->get('/', 'HomeController::index');

// ============ OPERATEUR ============

// Routes publiques (login) — PAS de filter
$routes->group('operateur', function ($routes) {
    $routes->get('login', 'Operateur\AuthController::login');
    $routes->post('login', 'Operateur\AuthController::attemptLogin');
    $routes->get('logout', 'Operateur\AuthController::logout');
});

// Routes protégées — filter operateurAuth
$routes->group('operateur', ['filter' => 'operateurAuth'], function ($routes) {
    $routes->get('dashboard', 'Operateur\DashboardController::index');

    $routes->resource('prefixes', ['controller' => 'Operateur\PrefixeController']);
    $routes->resource('types-baremes', ['controller' => 'Operateur\TypeBaremeController']);

    $routes->get('situation-gains', 'Operateur\SituationController::gains');
    $routes->get('situation-comptes', 'Operateur\SituationController::comptes');
});

// ============ CLIENT ============

// Routes publiques (login) — PAS de filter
$routes->group('client', function ($routes) {
    $routes->get('login', 'Client\AuthController::login');
    $routes->post('login', 'Client\AuthController::attemptLogin');
    $routes->get('logout', 'Client\AuthController::logout');
});

// Routes protégées — filter clientAuth
$routes->group('client', ['filter' => 'clientAuth'], function ($routes) {
    $routes->get('dashboard', 'Client\DashboardController::index');
    $routes->match(['get', 'post'], 'depot', 'Client\OperationController::depot');
    $routes->match(['get', 'post'], 'retrait', 'Client\OperationController::retrait');
    $routes->match(['get', 'post'], 'transfert', 'Client\OperationController::transfert');
    $routes->get('historique', 'Client\OperationController::historique');
    $routes->get('check-destinataire', 'Client\OperationController::checkDestinataire');
    $routes->match(['get', 'post'], 'transfert-multiple', 'Client\OperationController::transfertMultiple');
});


$routes->get('operateur/commission', 'Operateur\CommissionController::index');
$routes->post('commission/update', 'Operateur\CommissionController::update');
