<?php

return [

    // this routes are supposed to be accessible 
    // without being logged in
    'excluded_paths' => [
        '/',
        '/market',
        '/user/login',
        '/user/register',
        '/user/profile'
    ]

];