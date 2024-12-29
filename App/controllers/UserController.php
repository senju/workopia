<?php

namespace App\controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;
class UserController {

    protected $db;

    public function __construct() {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function login() {
        loadView('users/login');
    }

    public function create() {
        loadView('users/create');
    }

    public function store() {
        $name = $_POST['name'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];

        $errors = [];

        if(!Validation::string($name, 2, 50)) {
            $errors['name'] = 'Name must be atleast between 2 to 50 characters';
        }

        if(!Validation::email($email)) {
                    $errors['email'] = 'Please enter valid email address';
        }

        if(!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be atleast 6 characters';
        }

        if(!Validation::confirm($password, $passwordConfirmation)) {
            $errors['password_confirmation'] = 'Password does not match';
        }

        if(!empty($errors)) {
            loadView('users/create', [
                'errors' => $errors,
                'users' => [
                'name' =>$name,
                'email' =>$email,
                'city' => $city,
                'state' => $state
                ]
            ]);
            exit;
        }

        $params = [
            'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM USERS WHERE email = :email', $params)->fetch();

        if($user) {
            $errors['email'] = 'That email already exists';
            loadView('users/create',[
                'errors' => $errors
            ]);
            exit;
        }

        $params = [
            'name' =>$name,
            'email' =>$email,
            'city' => $city,
            'state' => $state,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $this->db->query('INSERT INTO USERS (name, email, city, state, password) VALUES (:name, :email, :city, :state, :password)', $params);

        $userId = $this->db->conn->lastInsertId();

        Session::set('user', [
        'id' => $userId,
        'name' => $name,
        'email' => $email,
        'city' => $city,
        'state' => $state
        ]);

        redirect('/');
    }

    public function logout() {
        Session::clearAll();
        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);
        redirect('/');
    }

    /**
     * Summary of authenticate login
     * @return void
     */
    public function authenticate() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        if(!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        if(!Validation::string($password, 6)) {
            $errors['password'] = 'Please enter atleast 6 characters';
        }

        if(!empty($errors)) {
            loadView('users/login',[
                'errors' => $errors
            ]);
            exit;
        }

        $params = [
            'email' => $email
        ];

        $user = $this->db->query("SELECT * FROM users WHERE email = :email", $params)->fetch();
        if(!$user) {
            $errors['email'] = 'Incorrect credentials';
            loadView('users/login',[
                'errors' => $errors
            ]);
            exit;
        }

        if(!password_verify($password, $user['password'])){
            $errors['password'] = 'Incorrect credentials';
            loadView('users/login',[
                'errors' => $errors
            ]);
            exit;
        }

        Session::set('user',[
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'city' => $user['city'],
            'state' => $user['state']
        ]);
        redirect('/');
    }
}