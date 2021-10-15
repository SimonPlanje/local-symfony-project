<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post', name: 'post.')]

class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request){

        //create a new poset with title
        $post = new Post();
        $post->setTitle('This is going to be a title');
        $post->setDescription('This is the first description');
        
        //entity manager
        $em = $this->getDoctrine()->getManager();
        
        // Tell doctrine u want to save the Post
        $em->persist($post);

        // acutally executes the queries (i.e the INSERT query)
        $em->flush();
        
        //return a response
        return new Response('Saved new post with id: '.$post->getId());
        
    }

    #[Route('/{id}', name: 'show')]
    public function show(int $id, PostRepository $postRepository): Response 
    {
        $post = $postRepository
            ->find($id);

        if (!$post){
            throw $this->createNotFoundException(
                'No post found for id'.$id
            );
        }
        return new Response('Check out this great product: '.$post->getTitle());
    }
    
}