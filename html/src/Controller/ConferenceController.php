<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Form\VoteType;
use App\Manager\ConferenceManager;
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
    public function index(Conference $conference, request $request, VoteManager $voteManager)
    {

        $voteConference = $voteManager->searchVoteByIdConference($conference);
        $rating = $voteManager->ratings($conference);
        $render = ['conference' => $conference, 'votes' => $voteConference, 'rating' => $rating];

        $vote = new Vote();
        if (!empty($this->getUser())) {
            $user = $this->getUser();
            if (empty($voteManager->searchUserAsAlreadyVoteConference($conference, $user))) {
                $form = $this->createForm(VoteType::class, $vote);
                $form->handleRequest($request);
                $render += ['form' => $form->createView()];
                if ($form->isSubmitted() && $form->isValid()) {
                    $vote->setUser($user);
                    $vote->setConference($conference);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($vote);
                    $entityManager->flush();
                    return $this->redirectToRoute('conference_page', ['id' => $conference->getId()]);
                }
            }
        }
        return $this->render('conference/index.html.twig', $render);
    }

    /**
     * @Route("/conferencevoted", name="conference_voted")
     */
    public function conferenceVoted(ConferenceManager $conferenceManager)
    {

        $pageConf=$conferenceManager->conferenceVoteExist();
        return $this->render('conference/conferencevoted.html.twig', [
            'conferences' => $pageConf,
        ]);
    }
    /**
     * @Route("/conferencenotvoted", name="conference_notvoted")
     */
    public function conferenceNotVoted(ConferenceManager $conferenceManager)
    {

        $pageConf=$conferenceManager->conferenceVoteNotExist();
        return $this->render('conference/conferencenotvoted.html.twig', [
            'conferences' => $pageConf,
        ]);
    }
}
