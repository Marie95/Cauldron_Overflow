<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response("homepage");
    }

    /**
     * @Route("/question/{id}")
     */
    public function show($id)
    {
        $answers = [
            'Make sure your cat is sitting purrrfectly still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];
        return $this->render('question/show.html.twig', ['id' => $id, 'answers' => $answers]);
    }

}