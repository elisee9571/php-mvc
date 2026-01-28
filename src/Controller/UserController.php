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
        $criteria = $_GET;

        if (isset($_GET['q'])) {
            $data = $repo->findBySearch($_GET['q'], $criteria);
        } else {
            $data = $repo->findAll($criteria);
        }

        $this->render('user/user', [
            'title' => 'List users',
            'users' => $data['users'],
            'count' => $data['count']
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
            'title' => 'User informations',
            'user' => $user
        ]);
    }

    public function new(): void
    {
        $user = new User();
        /* add $_POST */
        $manager = new EntityManager();

        $manager->persist($user);
        $manager->flush();

        $this->render('user/new', [
            'title' => 'Create user',
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

//        $user->setUsername('csdfvgbjhdc');

        $manager = new EntityManager();
        $manager->persist($user);
        $manager->flush();

        $this->render('user/edit', [
            'title' => 'Edit user',
            'user' => $user
        ]);
    }
}
