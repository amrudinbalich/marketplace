<?php

namespace App\Http\Controllers;

class HomeController
{
    public function index()
    {
        echo 'Home Page';
    }

    public function about()
    {
        echo "This is the about page";
    }

    public function user(int $id)
    {
        echo "User ID is: " . $id;
    }
}