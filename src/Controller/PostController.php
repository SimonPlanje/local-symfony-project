<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/post', name: 'post_')]

class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PostRepository $postRepository): Response
    {
        //$posts = $postRepository->findBy([], ['date'=>'desc'], 5);

        $posts = $postRepository->getIndexPosts();

        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'posts' => $posts,
        ]);
    }
    
    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // $form->getData() holds the submitted values 
            // but the original post variables has also been updated
            // $post = $form->getData();
            // Get entity manager
            $em = $this->getDoctrine()->getManager();
            
            // Tell doctrine u want to save the Post
            $em->persist($post);
            // foreach($post->getTags() as $tag){
            //     $em->persist($tag);
            // }
            
            // dump($post->getTags());
            // die();

            // Acutally executes the queries (i.e the INSERT query)
            $em->flush();

            return $this->redirectToRoute('post_index');
        }



        return $this->renderForm('post/create.html.twig',[
            'form' => $form,
        ]); 
        


        // Automatic 

        // // Create a new post with title
        // $post = new Post();
        // $post->setTitle('This is going to be a title');
        // $post->setDescription('This is the first description');
        
        // // Get entity manager
        // $em = $this->getDoctrine()->getManager();
        
        // // Tell doctrine u want to save the Post 
        // $em->persist($post);

        // // Acutally executes the queries (i.e the INSERT query)
        // $em->flush();
        
        // // Return a response
        // return new Response('Saved new post with id: '.$post->getId());
        
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
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }  
    
    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, int $id, PostRepository $postRepository): Response 
    {
        $em = $this->getDoctrine()->getManager();
        $post = $postRepository
            ->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Get entity manager
            $em = $this->getDoctrine()->getManager();
            
            // Tell doctrine u want to save the Post
            $em->persist($post);

            // Acutally executes the queries (i.e the INSERT query)
            $em->flush();

            // Return to the read page after updating the form
            return $this->redirectToRoute('post_index');
        }

        // Render the form so you can edit it
        return $this->renderForm('post/update.html.twig',[
            'form' => $form,
        ]); 

        // OLD CODE FOR UPDATING THE POST
        // $post->setTitle('New product name!');
        // $em->flush();

        // return $this->redirectToRoute('post_index');
    } 
    #[Route('/delete/{id}', name: 'delete', methods: 'POST')]
    public function deleteAction(Request $request, int $id, PostRepository $postRepository): Response 
    {
        $em = $this->getDoctrine()->getManager();
        $post = $postRepository
            ->find($id);

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if (!$post) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Tell doctrine u want to save the Post
        $em->remove($post);

        // Acutally executes the queries (i.e the INSERT query)
        $em->flush();

        // Return to the read page after updating the form
        return $this->redirectToRoute('post_index');
    } 
}