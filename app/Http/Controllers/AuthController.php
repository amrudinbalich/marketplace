<?php

namespace App\Http\Controllers;

use Amrudinbalic\Marketplace\Http\Request;
use Amrudinbalic\Marketplace\Http\Session;

use App\Models\User;

/**
 * AuthController class.
 * This controller is responsible for more user session-related actions.
 * As well for registering new user.
 */
class AuthController {

        public function __construct(
            public User $user
        ) {}

        // insert/search actions
        public function register(Request $request) 
        {
            [$name, $email, $password] = $request->validate(['name', 'email', 'password']);

            try {
                $insertId = $this->user->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT)
                ]);
            } catch (\Exception $e) {
                if($e->getCode() == 23000) {
                    redirect('user/register', ['error' => 'User like this already exists.']);
                }
            }

            $user = $this->user->get($insertId);
            $_SESSION['user'] = $user;

            redirect('market', [
                'success' => 'Registration successful! Thanks for using our service.'
            ]);
        }

        public function login(Request $request)
        {
            [$name, $password] = $request->validate(['name', 'password']);

            $found = $this->user->authenticate($name, $password);

            if (!$found) {
                redirect('user/login', 
                    ['error' => 'Invalid credentials.']
                );
            }
            
            // user is already remembered up to this point
            // in the model code ...

            redirect('market', [
                'success' => 'You have been successfully logged in.'
            ]);
        }

        // profile actions (auth protected)
        public function profile(): string
        {
            // todo: move this to middleware
            $user = $_SESSION['user'] ?? null;
    
            if(!$user) {
                return twig('user/login', [
                    'error' => 'You must be logged in to view your profile.'
                ]);
            }
            // replace::end

            $user = $this->user->fetchProfile($user['id']);
    
            return twig('user/profile', [
                'user' => $user
            ]);
        }

        public function profileSettings(): string
        {
            // todo: move this to middleware
            $user = $_SESSION['user'] ?? null;

            if(!$user) {
                return twig('user/login', [
                    'error' => 'You must be logged in to view your profile.'
                ]);
            }
            // replace::end

            $user = $this->user->fetchProfile($user['id']);
                        
            return twig('user/profile-settings', [
                'user' => $user
            ]);
        }
        
        public function logout(): void {
            Session::destroy();
            redirect('user/login', [
                'success' => 'You have been successfully logged out.']);
        }

}