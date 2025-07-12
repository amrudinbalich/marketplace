<?php

// currently cannot setup .htaccess to redirect to public/index.php
// so we are redirecting to it manually

header('Location: public/index.php');
exit;