<?php


namespace App\Controller;


use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(QuestionRepository $repository)
    {
//        $repository = $entityManager->getRepository(Question::class);
//        $questions = $repository->findAll();
        $questions = $repository->findAllAskedOrderedMyNewest();
        return $this->render('homepage.html.twig', [
            'questions' => $questions
        ]);
    }

    /**
     * @Route("/questions/new", name="app_fake_question_entry", methods="GET")
     */
    public function new(EntityManagerInterface $entityManager)
    {

        return new Response('Future Feature');
    }

    /**
     * @Route("/questions/{slug}", name="app_question_show")
     */
    public function show(Question $q)
    {
        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];

        return $this->render('question/show.html.twig', [
            'question' => $q,
            'answers' => $answers
        ]);
    }

    /**
     * @Route("/questions/{slug}/vote", name="app_question_vote", methods="POST")
     */
    public function questionVote(Question $question, Request $request, EntityManagerInterface $entityManager)
    {
        $direction = $request->request->get('direction');

        if($direction === 'up') {
            $question->upVote();
        } else if($direction === 'down') {
            $question->downVote();
        }
        $entityManager->flush();

        return $this->redirectToRoute('app_question_show', [
            'slug' => $question->getSlug()
        ]);
    }
}