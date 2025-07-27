<?php

namespace App\Http\Controllers;

use Amrudinbalic\Marketplace\Http\Request;
use Amrudinbalic\Marketplace\Http\Session;

use App\Models\User;

/**
 * UserController
 * Handlers user-related actions, such as fetching user related data, updating it etc... 
 * If you want to look at more-profile related actions, look at AuthController.php
 * This controller is more about other user(s) data on the app.
 * 
 * You like playing video games?
 * Take this as a reference:
 * AuthController - Main character
 * UserController - NPCs
 */
class UserController
{

    /**
     * Possible implementations:
     * ✅ Browse other users' profiles
     * ✅ View other users' articles
     * ✅ Get other users' stats (articles sold, ratings, etc.)
     * ✅ Search/filter users
     * ✅ Public user information
     */


    public function get(Request $request) {
//        return $twig->render('user/get.twig', ['id' => $id]);
    }

}