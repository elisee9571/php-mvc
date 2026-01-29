<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\EntityManager;
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
            'title' => 'Profil user',
            'user' => $user
        ]);
    }

    public function edit(int $id): void
    {
        $repo = new UserRepository();
        $user = $repo->findById($id);

        if (!$user) {
            throw new \Exception('User not found', 400);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_FILES['picture']['tmp_name'])) {
                $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('avatar_', true) . '.' . $ext;

                $destDir = dirname(__DIR__) . '/../public/uploads/avatars';
                if (!is_dir($destDir)) mkdir($destDir, 0775, true);

                move_uploaded_file($_FILES['picture']['tmp_name'], $destDir . '/' . $filename);

                $user->setPicture('/uploads/avatars/' . $filename);
            }

            $user->setUsername($_POST['username'])
                ->setEmail($_POST['email']);

            $manager = new EntityManager();
            $manager->persist($user);
            $manager->flush();

            $this->redirect("/user/{$id}");
        }

        $this->render('user/edit', [
            'title' => 'Edit user',
            'user' => $user
        ]);
    }
}
