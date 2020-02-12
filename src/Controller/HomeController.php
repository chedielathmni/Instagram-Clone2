<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $user = $this->getUser();
        $usersFollowed[] = $user;
        foreach ($user->getFollowing() as &$val) {
            array_push($usersFollowed, $val);
        }
        $posts = array();
        foreach ($usersFollowed as &$val) {
            foreach ($val->getPosts() as &$val2) {
                array_push($posts, $val2);
            }
        }

        usort($posts, fn ($a, $b) => strcmp($a->getUpdatedAt()->format('Y-m-d H:i:s'), $b->getUpdatedAt()->format('Y-m-d H:i:s')));

        return $this->render('home.html.twig', [
            "posts" => $posts
        ]);
    }
}
