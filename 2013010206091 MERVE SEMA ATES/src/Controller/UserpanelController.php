<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserpanelController extends AbstractController
{
    /**
     * @Route("/userpanel", name="userpanel")
     */
    public function index()
    {
        return $this->render('userpanel/show.html.twig' );
    }


    /**
     * @Route("/useredit", name="userpanel_edit", methods="GET|POST")
     */
    public function edit(Request $request)
    {
        $usersession = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($usersession->getid());
        if($request->isMethod('POST')) {
            $submittedToken = $request->request->get('token');
            if ($this->isCsrfTokenValid('user-form', $submittedToken)) {
                $user->setName($request->request->get('name'));
                $user->setPassword($request->request->get('password'));
                $user->setAddress($request->request->get('address'));
                $user->setCity($request->request->get('city'));
                $user->setPhone($request->request->get('phone'));
                $this->getDoctrine()->getManager()->flush();
                return $this->render('userpanel/show.html.twig');
            }
        }
        return $this->render('userpanel/edit.html.twig', ['user'=>$user]);
    }


    /**
     * @Route("/show", name="userpanel_show",methods="GET")
     */
    public function show()
    {
        return $this->render('userpanel/show.html.twig' );
    }
}
