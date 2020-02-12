<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{

    /**
     * @var 
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, PostRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }


    /**
     * @Route("/{slug}-{id}/post/add", name="post.new", requirements={"slug": "[a-z0-9\-]*"})
     * @param User $user
     * @param string $slug
     * @return Response
     */
    public function new(string $slug, Request $req): Response
    {
        $user = $this->getUser();
        if ($user->getSlug() !== $slug) {
            return $this->redirectToRoute('home');
        }

        $post = new Post;

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->addPost($post);
            $this->em->persist($post);
            $this->em->flush();
            return $this->redirectToRoute('profile.show', [
                'id' => $user->getId(),
                'slug' => $user->getSlug()
            ]);
        }

        return $this->render('post\new.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/{slug}-{id}/{postId}", name="post.show", requirements={"slug": "[a-z0-9\-]*", "postId": "[0-9]*"})
     * @param User $user
     * @return Response
     */
    public function show(User $user, int $postId): Response
    {
        $posts = $user->getPosts()->getValues();
        dump($posts);
        if (isset($posts[$postId - 1]))
            return $this->render('post/show.html.twig', [
                'user' => $user,
                'post' => $posts[$postId - 1]
            ]);
        else return new Response('not found');/* $this->redirectToRoute('home'); */
    }
}
