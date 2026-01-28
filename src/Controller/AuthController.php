<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\EntityManager;
use App\Model\User;
use App\Repository\UserRepository;

class AuthController extends Controller
{
    public function register(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['username'])) {
            $this->redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = new User();
            $user->setUsername($_POST['username'])
                ->setEmail($_POST['email'])
                ->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));

            $manager = new EntityManager();
            $manager->persist($user);
            $manager->flush();

            $this->redirect('/login');
        }

        $this->render('auth/register', [
            'title' => 'Sign Up',
        ]);
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['username'])) {
            $this->redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $repo = new UserRepository();
            $user = $repo->findByEmail($_POST['email']);

            if (!$user) {
                throw new \Exception('Wrong credentials', 400);
            }

            if (password_verify($_POST['password'], $user->getPassword())) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['userId'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['email'] = $user->getEmail();

                $this->redirect('/');
            } else {
                throw new \Exception('Wrong credentials', 400);
            }
        }

        $this->render('auth/login', [
            'title' => 'Sing in'
        ]);
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();

        $this->redirect('/');
    }
}
