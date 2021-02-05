<?php


namespace App\Controller;


use App\service\MarkdownHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('homepage.html.twig');
    }

    /**
     * @Route("/question/{id}", name="app_question_show")
     */
    public function show($id, MarkdownHelper $mdHelper)
    {
        dump($this->getParameter('kernel.charset'));
        $questionText = 'I\'ve been turned into a **cat**, any thoughts on how to turn back? While I\'m adorable, I don\'t really care for cat food.';
        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];
        $parsedQuestionText = $mdHelper->parse($questionText);
        return $this->render('question/show.html.twig', ['questionText' => $parsedQuestionText, 'id'=> $id, 'answers' => $answers]);
    }

}