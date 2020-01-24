<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Editor;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EditorController extends AbstractController
{
    /**
     * @Route("/editor", name="editor", methods={"POST"})
     */
    public function index()
    {
				$editors = $this->getDoctrine()->getRepository(Editor::class)->findAll();

				$response = [];

				foreach ($editors as $editor) {
					$response[] = [
						'id' => $editor->getId(),
						'name' => preg_replace('/\s+/', ' ', str_replace("\n", '', $editor->getName())),
					];
				}

        return $this->json($response);
    }
		/**
     * @Route("/editor/{id}", name="editor_detail", requirements={"id"="\d+"})
     */
		 public function editor($id)
		 {
			 $editor = $this->getDoctrine()->getRepository(Editor::class)->find($id);

			 if (!$editor) {
				 throw new NotFoundHttpException('Sorry not existing!');
			 }

			 $games = [];

			 foreach ($editor->getGames() as $game) {
				 $games[] = [
					 'id' => $game->getId(),
					 'name' => $game->getName(),
				 ];
			 }
			 dump($games);
			 $response = [
				 'id' => $editor->getId(),
				 'name' => $editor->getName(),
				 'games' => $games,
			 ];

			 return $this->json($response);
		 }
}
