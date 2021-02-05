<?php


namespace App\Controller;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{


    /**
     * @Route("/comments/{id}/vote/{direction<up|down>}", methods="POST")
     */
    public function commentVote($id, $direction, LoggerInterface $logger)
    {
        //todo database

        if($direction === 'up'){
            $currentVoteCount = rand(7, 100);
            $logger->info('Voting up!');
        } else {
            $currentVoteCount = rand(0, 5);
            $logger->info('Voting down!');
        }
        return new JsonResponse(['votes' => $currentVoteCount]);
    }

}