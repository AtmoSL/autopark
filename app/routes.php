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
Router::get('/car/edit', 'CarController', 'edit');