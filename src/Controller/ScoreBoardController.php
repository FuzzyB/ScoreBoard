<?php

namespace App\Controller;

use App\Form\ScoreBoard\GameType;
use App\Game;
use App\GameManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ScoreBoardController extends AbstractController
{
    #[Route('/score/board', name: 'app_score_board')]
    public function index(Environment $twig, GameManager $gameManager, Request $request): Response
    {
        $gameManager->startGame('Poland', 'Brazil');

        $games = $gameManager->getList();
        $game = $games[0] ?? new Game('Home Team', 'Away Team', 0, 0 );
        $form = $this->createForm(GameType::class, $game);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($game);
            return new Response("Some response");
        } else {
            dd('nie znalezion');
        }

        return new Response($twig->render('scoreBoard/show.html.twig', [
            'game_form' => $form->createView()
        ]));

//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/ScoreBoardController.php',
//        ]);
    }
}
