<?php

namespace App\Http\Controllers;

class MarketController
{
    public function index()
    {
        return twig('market');
    }
}