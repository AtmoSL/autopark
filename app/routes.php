<?php

use service\Router;

Router::addRoute('/', 'UserController', 'login');
Router::addRoute('/login', 'UserController', 'login');
Router::addRoute('/register', 'UserController', 'register');
Router::addRoute('/profile', 'UserController', 'profile');
Router::addRoute('/logout', 'UserController', 'logout');

Router::post('/createuser', 'UserController', 'createuser');
Router::post('/auth', 'UserController', 'auth');

Router::addRoute('/cars', 'CarController', 'driverCars');
Router::addRoute('/cars/new', 'CarController', 'new');
Router::get('/car/edit', 'CarController', 'edit');
Router::post('/car/editForm', 'CarController', 'editForm');
Router::post('/cars/newForm', 'CarController', 'newForm');

Router::addRoute('/autoparks', 'AutoparkController', 'all');
Router::addRoute('/autoparks/new', 'AutoparkController', 'new');
Router::get('/autopark/edit', 'AutoparkController', 'edit');
Router::get('/autopark/delete', 'AutoparkController', 'delete');
Router::post('/autopark/edit/addcar', 'AutoparkController', 'addCarToAutopark');
Router::post('/autopark/editForm', 'AutoparkController', 'editForm');
Router::post('/autopark/newForm', 'AutoparkController', 'newForm');
