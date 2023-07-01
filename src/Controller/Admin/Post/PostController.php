<?php

namespace App\Controller\Admin\Post;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PostController extends AbstractController
{
    #[Route('/admin/post', name: 'admin.post.index')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        return $this->render('pages/admin/post/index.html.twig', compact('posts'));
    }


    #[Route('/admin/post/create', name: 'admin.post.create', methods: ['GET', 'POST'])]
    public function create(Request $request, PostRepository $postRepository): Response
    {
        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $postRepository->save($post, true);
            $this->addFlash("success", "Le post a été ajouté avec succès.");
            return $this->redirectToRoute("admin.post.index");
        }

        return $this->render('pages/admin/post/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/admin/post/{id<[0-9]+>}/edit', name: 'admin.post.edit', methods: ['GET', 'POST'])]
    public function edit(Post $post, Request $request, PostRepository $postRepository): Response
    {
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $postRepository->save($post, true);

            $this->addFlash("success", "Ce post a été modifé avec succès ! ");
            return $this->redirectToRoute("admin.post.index");
        }

        return $this->render("pages/admin/post/edit.html.twig", [
            "form" => $form->createView(),
            "post" => $post
        ]);
    }

    #[Route('/admin/category/{id<[0-9]+>}/delete', name: 'admin.post.delete', methods: ['POST'])]
    public function delete(Post $post, Request $request, PostRepository $postRepository) : Response
    {
        if ($this->isCsrfTokenValid('post_' . $post->getId(), $request->request->get('_csrf_token') )) {

            $postRepository->remove($post, true);
            $this->addFlash("success", "Le post " . $post->getTitle() . " a été suprimée.");
        } 

        return $this->redirectToRoute('admin.post.index');
    }

}
