<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\Redirect;

class LogoutController
{
    public function logout(): Redirect
    {
        unset($_SESSION);

        return new Redirect('/login');
    }
}