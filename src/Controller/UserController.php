<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\EntityManager;
use App\Model\User;
use App\Repository\UserRepository;

final class UserController extends Controller
{
    public function index(): void
    {
        $repo = new UserRepository();

        if (isset($_GET['search'])) {
            $users = $repo->findBySearch($_GET['q']);
        } else {
            $users = $repo->findAll();
        }

        $this->render('user/user', [
            'title' => 'Liste des utilisateurs',
            'users' => $users
        ]);
    }

    public function show(int $id): void
    {
        $repo = new UserRepository();
        $user = $repo->findById($id);

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        $this->render('user/show', [
            'title' => 'Profil utilisateur',
            'user' => $user
        ]);
    }

    public function new(): void
    {
        $user = new User();
        $user
            ->setUsername('Username789')
            ->setEmail('elis@gmail.com')
            ->setPassword('sxdcfgvhbjnk');

        $manager = new EntityManager();

        $manager->persist($user);
        $manager->flush();

        $this->render('user/new', [
            'title' => 'Créer un utilisateur',
            'user' => $user
        ]);
    }

    public function edit(int $id): void
    {
        $repo = new UserRepository();
        $user = $repo->findById($id);

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        $user->setUsername('csdfvgbjhdc');

        $manager = new EntityManager();
        $manager->persist($user);
        $manager->flush();

        $this->render('user/edit', [
            'title' => 'Modifier un utilisateur',
            'user' => $user
        ]);
    }
}