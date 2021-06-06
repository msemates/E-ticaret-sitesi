<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrderDetail;

use App\Form\OrdersType;
use App\Repository\OrderDetailRepository;
use App\Repository\OrdersRepository;
use App\Repository\ShopcartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="orders_index", methods="GET")
     */
    public function index(OrdersRepository $ordersRepository): Response
    {
        $user = $this->getUser(); //Calling Login user data
        $userid = $user->getid();

        return $this->render('orders/index.html.twig', ['orders' => $ordersRepository->findBy(['userid' => $userid])]);
    }

    /**
     * @Route("/new", name="orders_new", methods="GET|POST")
     */
    public function new(Request $request, ShopcartRepository $shopcartRepository): Response
    {
        $order = new Orders();
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        $user = $this->getUser(); //Login olan kişinin bilgilerine erişme
        $userid = $user->getid();
        $total = $shopcartRepository->getUserShopCartTotal($userid);



        $submittedToken= $request->request->get('token');  //get csrf token information
        if($this->isCsrfTokenValid('form-order', $submittedToken)) {
            if ($form->isSubmitted()) {
                //Kredi kartı bilgilerini ilgili banka servisine gönder
                //Onay gelirse kaydetmeye devam et yoksa order sayfasına hata gönder

                $em = $this->getDoctrine()->getManager();

                $order->setUserId($userid);
                $order->setAmount($total);
                $order->setStatus("New");

                $em->persist($order);
                $em->flush();

                $orderid = $order->getId();  //Get last insert orders data id

                $shopcart=$shopcartRepository->getUserShopCart($userid); //Toplam miktarı getiren fonksiyon

                foreach($shopcart as $item){

                    $orderdetail = new OrderDetail();

                    $orderdetail->setOrderId($orderid);
                    $orderdetail->setUserId($user->getid()); //
                    $orderdetail->setProductId($item["productid"]);
                    $orderdetail->setPrice($item["sprice"]);
                    $orderdetail->setQuantity($item["quantity"]);
                    $orderdetail->setAmount($item["total"]);
                    $orderdetail->setName($item["title"]);
                    $orderdetail->setStatus("Ordered");

                    $em->persist($orderdetail);
                    $em->flush();
                }
                //Delete User Shopcart Products
                $em = $this->getDoctrine()->getManager();
                $query = $em->createQuery('
           DELETE FROM App\Entity\Shopcart s WHERE s.userid=:userid
           ')
                    ->setParameter('userid',$userid);
                $query->execute();

                $this->addFlash('success', 'Siparişiniz Başarıyla Gerçekleştirilmiştir <br> Teşekkür Ederiz ');
                return $this->redirectToRoute('orders_index');
            }
        }

        return $this->render('orders/new.html.twig', [
            'order' => $order,
            'total' => $total,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="orders_show", methods="GET")
     */
    public function show(Orders $order, OrderDetailRepository $orderDetailRepository): Response
    {
        $user = $this->getUser(); //Calling Login user data
        $userid = $user->getid();
        $orderid = $order->getid();

        $orderdetail= $orderDetailRepository->findBy(
            ['orderid' => $orderid]
        );

        return $this->render('orders/show.html.twig', [
            'order' => $order,
            'orderdetails' => $orderdetail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="orders_edit", methods="GET|POST")
     */
    public function edit(Request $request, Orders $order): Response
    {
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orders_edit', ['id' => $order->getId()]);
        }

        return $this->render('orders/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="orders_delete", methods="DELETE")
     */
    public function delete(Request $request, Orders $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($order);
            $em->flush();
        }

        return $this->redirectToRoute('orders_index');
    }
}
