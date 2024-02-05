<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Mastermind; 
use App\Entity\iMastermind; 
use Symfony\Component\HttpFoundation\Session\SessionInterface; // If you're using sessions


class MasterController extends AbstractController
{

    #[Route("/check", name: "check")]
    public function Check(Request $request, SessionInterface $session): RedirectResponse 
    {
        if (!$session->has('mastermind')) {
            return $this->redirectToRoute('master'); // Handle case where 'mastermind' session doesn't exist
        }
        $mastermind = unserialize($session->get('mastermind'));
        $code = $request->query->get('code');
        $mastermind->test($code);
        $session->set('mastermind', serialize($mastermind));
        return $this->redirectToRoute('master');
    }
    
    #[Route("/new", name: "new")]
    public function new(Request $request, SessionInterface $session): RedirectResponse 
    {
        $session->remove('mastermind');
        return $this->redirectToRoute('master');
    }
    
    #[Route('/master', name: 'master')]
    public function master(Request $request, SessionInterface $session) : Response
    {
        if ($session->has('mastermind')) {
            $mastermind = unserialize($session->get('mastermind'));
        }
        else 
        $mastermind = new Mastermind(); 
        $session->set('mastermind', serialize($mastermind));
        //dd($mastermind->getEssais());
        return $this->render('master/mastermind.html.twig', [
            'controller_name' => 'MasterController',
            'mastermind' => $mastermind,
            'Essais' => $mastermind->getEssais(),
            'Fini' => $mastermind->isFini(),
        ]);
    }
}

