<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Joke;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LikesController extends Controller
{
    /**
     * @Route("joke/like/{jokeId}", name="likeJoke")
     */
    public function likeAction($jokeId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $joke = $entityManager->getRepository(Joke::class)->find($jokeId);

        if (!$joke) {
            throw $this->createNotFoundException(
                'No product found for id '.$joke
            );
        }
        $joke->setLikes($joke->getLikes()+1);
        $entityManager->flush();

        return $this->redirectToRoute('allJokes');

    }

    /**
     * @Route("joke/dislike/{jokeId}", name="dislikeJoke")
     */
    public function dislikeAction($jokeId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $joke = $entityManager->getRepository(Joke::class)->find($jokeId);

        if (!$joke) {
            throw $this->createNotFoundException(
                'No product found for id '.$joke
            );
        }
        $joke->setLikes($joke->getLikes()-1);
        $entityManager->flush();

        return $this->redirectToRoute('allJokes');

    }
}
