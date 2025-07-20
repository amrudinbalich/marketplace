<?php

namespace App\Http\Controllers;

use Amrudinbalic\Marketplace\Http\Request;
use Amrudinbalic\Marketplace\Http\Session;

use App\Models\User;

/**
 * AuthController class.
 * 
 * It handles the user registration/login and general profile management that is active
 * through the user session.
 * 
 * It is supposed to be separated, yet very close to the UserController - not to be confused.
 */
class AuthController {

        // register
        public function register(): string
        {
            return twig('user/register');
        }
        public function actionRegister(Request $request)
        {
            [$name, $email, $password] = $request->validate(['name', 'email', 'password']);
    
            try {
    
                $user = new User();
                $user->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT)
                ]);
    
                redirect('', ['success' => 'Registration successful! You can now log in.']);
    
            } catch (\Exception $e) {
    
                if($e->getCode() === '23000') {
                    $message = 'User with this credentials already exists.';
                } else {
                    $message = 'An unexpected error occurred.';
                }
    
                redirect('user/register', ['error' => 'Registration failed: ' . $message]);
            }
        }
        // register::end
    
        // login
        public function login(): string
        {
            return twig('user/login');
        }
        public function actionLogin(Request $request)
        {
            $email = $request->query('email');
            $password = $request->query('password');
        }
        // login::end
    
        public function profile(): string
        {
    
            $user = $_SESSION['user'] ?? null;
    
            if(!$user) {
                return twig('user/login', [
                    'error' => 'You must be logged in to view your profile.'
                ]);
            }
    
            return twig('user/profile', [
                'user' => $user
            ]);
        }
    
        public function logout(): void {
            Session::destroy();
            redirect('', ['logged_out' => 'You have been successfully logged out.']);
        }
}