<?php

namespace App\Http\Controllers;

use Twig\Environment;

class HomeController
{
    public function __construct(Environment $twig) {}

    public function index(Environment $twig)
    {
        return $twig->render('home.twig', [
            'title' => 'Welcome!',
            'name' => 'Amrudin'
        ]);
    }

    public function about(Environment $twig)
    {
        return $twig->render('about.twig', [
            'title' => 'About Us'
        ]);
    }

    public function user(Environment $twig, int $id)
    {
        return $twig->render('user.twig', [
            'title' => 'User',
            'id' => $id
        ]);
    }
}