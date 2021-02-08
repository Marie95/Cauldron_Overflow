<?php


namespace App\Controller;


use App\Entity\Question;
use App\service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/questions/new", name="app_fake_question_entry", methods="GET")
     */
    public function new(EntityManagerInterface $entityManager)
    {
        $question = new Question();
        $question->setName('Missing pants');
        $question->setSlug('missing-pants-'.rand(0, 1000));
        $question->setQuestion(<<<EOF
            Hi! So... I'm having a *weird* day. Yesterday, I cast a spell
            to make my dishes wash themselves. But while I was casting it,
            I slipped a little and I think `I also hit my pants with the spell`.
            When I woke up this morning, I caught a quick glimpse of my pants
            opening the front door and walking out! I've been out all afternoon
            (with no pants mind you) searching for them.
            Does anyone have a spell to call your pants back?
EOF
            );
        if (rand(1, 10) > 2) {
            $question->setAskedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
        }
        $entityManager->persist($question);
        $entityManager->flush();
        return new Response(sprintf('Question id: #%d, slug: %s', $question->getId(), $question->getSlug()));
    }

    /**
     * @Route("/questions/{slug}", name="app_question_show")
     */
    public function show($slug, MarkdownHelper $mdHelper, EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Question::class);
        $q = $repository->findOneBy(['slug' => $slug]);
        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];
        $questionText = 'I\'ve been turned into a **cat**, any thoughts on how to turn back? While I\'m adorable, I don\'t really care for cat food.';

        $parsedQuestionText = $mdHelper->parse($questionText);
        return $this->render('question/show.html.twig', ['questionText' => $parsedQuestionText, 'slug'=> $slug, 'answers' => $answers]);
    }
}