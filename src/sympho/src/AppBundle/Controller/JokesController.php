<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Joke;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JokesController extends Controller
{
    /**
     * @Route("/", name="randomJoke")
     */
    public function randomAction(Request $request)
    {
        try {
            $repository = $this->getDoctrine()->getRepository(Joke::class);
            $joke = $repository->findOneRandom();


        }catch(Exception $e){
            $joke=false;
        }
        return $this->render('joke/random.html.twig',
            ['joke'=> $joke]);
    }

    /**
     * @Route("/joke/add", name="addJoke")
     */
    public function formAddAction(Request $request)
    {
        // creates a joke and gives it some dummy data for this example
        $joke = new Joke();
        $joke->setLikes(0);

        $form = $this->createFormBuilder($joke)
            ->add('name', TextType::class)
            ->add('joke', TextType::class)
            ->add('genre', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Joke'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $joke = $form->getData();

             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($joke);
             $entityManager->flush();

            return $this->redirectToRoute('allJokes');
        }

        return $this->render('joke/addJoke.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/joke/show/{jokeId}", name="showJoke")
     */
    public function showAction($jokeId)
    {
        $joke = $this->getDoctrine()
            ->getRepository(Joke::class)
            ->find($jokeId);

        if (!$joke) {
            throw $this->createNotFoundException(
                'No product found for id '.$jokeId
            );
        }

        return $this->render('joke/viewOne.html.twig', [
            'joke' => $joke
        ]);
    }

    /**
     * @Route("/joke/", name="allJokes")
     */
    public function showAllAction()
    {
        $jokes = $this->getDoctrine()
            ->getRepository(Joke::class)
            ->findAll();

//        if (!$jokes) {
//            throw $this->createNotFoundException(
//                'No jokes found'
//            );
//        }

        return $this->render('joke/viewAll.html.twig', [
            'jokes' => $jokes
        ]);
    }

    /**
     * @Route("/joke/edit/{jokeId}", name="editJoke")
     */
    public function EditAction(Request $request, $jokeId)
    {
        $joke = $this->getDoctrine()
            ->getRepository(Joke::class)
            ->find($jokeId);

        if (!$joke) {
            throw $this->createNotFoundException(
                'No product found for id '.$jokeId
            );
        }

        $form = $this->createFormBuilder($joke)
            ->add('name', TextType::class)
            ->add('joke', TextType::class)
            ->add('genre', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Edit Joke'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $joke = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($joke);
            $entityManager->flush();

            return $this->redirectToRoute('showJoke', ['jokeId' => $joke->getId()]);
        }

        return $this->render('joke/editJoke.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/joke/delete/{jokeId}", name="deleteJoke")
     */
    public function DeleteAction($jokeId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $joke = $entityManager->getRepository(Joke::class)->find($jokeId);

        if (!$joke) {
            throw $this->createNotFoundException(
                'No product found for id '.$joke
            );
        }
        $entityManager->remove($joke);
        $entityManager->flush();

        return $this->redirectToRoute('allJokes');

        return $this->render('allJokes', [
            'joke' => $joke
        ]);
    }



}