<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Game;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game")
     */
    public function index()
    {
				$games = $this->getDoctrine()->getRepository(Game::class)->findAll();

				$response = [];

				foreach ($games as $game) {
					$response[] = [
						'id' => $game->getId(),
						'name' => preg_replace('/\s+/', ' ', str_replace("\n", '', $game->getName())),
					];
				}

        return $this->json($response);
    }
		/**
     * @Route("/game/{id}", name="game_detail", requirements={"id"="\d+"})
     */
		 public function game($id)
		 {
			 $game = $this->getDoctrine()->getRepository(Game::class)->find($id);

			 if (!$game) {
				 throw new NotFoundHttpException('Sorry not existing!');
			 }

			 $editors = [];
			 $editor = $game->getEditor();
			 $editors[] = [
				 'id' => $editor->getId(),
				 'name' => $editor->getName(),
			 ];


			 $response = [
				 'id' => $game->getId(),
				 'name' => $game->getName(),
				 'editors' => $editors,
				 'description' => $game->getDescription(),
				 'date' => $game->getDate(),
				 'classification' => $game->getClassification(),
				 'cover' => $game->getCover(),
				 'review' => $game->getReview(),
				 'link' => $game->getLink(),
			 ];

			 return $this->json($response);
		 }
}
