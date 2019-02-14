<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Form\VoteType;
use App\Manager\VoteManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Conference;
use Symfony\Component\HttpFoundation\Request;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/conference/{id}", name="conference_page")
     * @param Conference $conference
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Conference $conference, request $request,VoteManager $voteManager)
    {

        $voteConference=$voteManager->searchVoteByIdConference($conference);
        $render= [ 'conference' => $conference,'votes' => $voteConference];

        $vote=new Vote();
        $user = $this->getUser();
        if (empty($voteManager->searchUserAsAlreadyVoteConference($conference, $user)))
        {
        $form = $this->createForm(VoteType::class,$vote);
        $form->handleRequest($request);
        $render += ['form' => $form->createView()];
        if ($form->isSubmitted() && $form->isValid()) {
            $vote->setUser($user);
            $vote->setConference($conference);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vote);
            $entityManager->flush();
            return $this->redirectToRoute('conference_page',['id' => $conference->getId() ] );
        }
        }
        return $this->render('conference/index.html.twig', $render);
    }
}
