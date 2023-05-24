<?php

namespace App\Controller\Admin\Post;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PostController extends AbstractController
{
    #[Route('/admin/post', name: 'admin.post.index')]
    public function index(): Response
    {
        return $this->render('pages/admin/post/index.html.twig');
    }


    #[Route('/admin/post/create', name: 'admin.post.create', methods: ['GET', 'POST'])]
    public function create(): Response
    {
        return $this->render('pages/admin/post/create.html.twig');
    }
}
