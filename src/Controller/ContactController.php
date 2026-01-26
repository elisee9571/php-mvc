<?php

namespace App\Controller;

use App\Core\Controller;

final class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('contact', [
            'title' => 'Contact'
        ]);
    }

    public function submit(): void
    {
        $this->render('contact', [
            'title' => 'Contact',
            'email' => $_POST['email'],
            'subject' => $_POST['subject'],
            'message' => $_POST['message']
        ]);
    }
}
