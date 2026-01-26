<?php

namespace App\Controller;

use App\Core\Controller;
use App\Repository\UserRepository;

final class HomeController extends Controller
{
    public function index(): void
    {
        $repo = new UserRepository();
        $users = $repo->findAll();

        $this->render('home', [
            'title' => 'Accueil',
            'users' => $users
        ]);
    }
}
