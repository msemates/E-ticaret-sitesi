<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Messages;
use App\Form\Admin\MessagesType;
use App\Repository\Admin\MessagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/messages")
 */
class MessagesController extends AbstractController
{
    /**
     * @Route("/", name="admin_messages_index", methods="GET")
     */
    public function index(MessagesRepository $messagesRepository): Response
    {
        return $this->render('admin/messages/index.html.twig', ['messages' => $messagesRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_messages_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('admin_messages_index');
        }

        return $this->render('admin/messages/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_messages_show", methods="GET")
     */
    public function show(Messages $message,$id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sql = 'UPDATE messages SET status="Okundu" WHERE  id= :id';
        $statement = $em->getConnection()->prepare($sql);
        $statement->bindValue('id', $id);
        $statement->execute();
        return $this->render('admin/messages/show.html.twig', ['message' => $message]);
    }

    /**
     * @Route("/{id}/edit", name="admin_messages_edit", methods="GET|POST")
     */
    public function edit(Request $request, Messages $message): Response
    {
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_messages_edit', ['id' => $message->getId()]);
        }

        return $this->render('admin/messages/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/update", name="admin_messages_update", methods="GET|POST")
     */
    public function message_update($id,Request $request, Messages $message): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sql = "UPDATE messages SET comment=:comment WHERE  id= :id";
        $statement = $em->getConnection()->prepare($sql);
        $statement->bindValue('comment', $request->request->get('comment'));
        $statement->bindValue('id', $id);
        $statement->execute();
        return $this->render('admin/messages/show.html.twig', ['message' => $message,
            'id'=>$id]
            );
    }

    /**
     * @Route("/{id}", name="admin_messages_delete", methods="DELETE")
     */
    public function delete(Request $request, Messages $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('admin_messages_index');
    }
}


