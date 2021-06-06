<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Setting;
use App\Form\Admin\SettingType;
use App\Repository\Admin\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/setting")
 */
class SettingController extends AbstractController
{
    /**
     * @Route("/", name="admin_setting_index", methods="GET")
     */
    public function index(SettingRepository $settingRepository): Response
    {
        $setdata= $settingRepository->findAll();

        if(!$setdata)
        {
            //echo "Setting Tablosu boş";
            $setting = new Setting();
            $em = $this->getDoctrine()->getManager();
            $setting->setTitle("Site");
            $em->persist($setting);
            $em->flush();
            $setdata= $settingRepository->findAll();
        }
        return $this->redirectToRoute('admin_setting_edit', ['id' => $setdata[0]->getId()]);
        //return $this->render('admin/setting/index.html.twig', ['settings' => $settingRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_setting_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $setting = new Setting();
        $form = $this->createForm(SettingType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($setting);
            $em->flush();

            return $this->redirectToRoute('admin_setting_index');
        }

        return $this->render('admin/setting/new.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_setting_show", methods="GET")
     */
    public function show(Setting $setting): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sql = 'SELECT * FROM product WHERE status="True" AND category_id = :catid';
        $statement = $em->getConnection()->prepare($sql);
        $statement->bindValue('catid', $catid);
        $statement->execute();
        return $this->render('admin/setting/show.html.twig', ['setting' => $setting]);
    }

    /**
     * @Route("/{id}/edit", name="admin_setting_edit", methods="GET|POST")
     */
    public function edit(Request $request, Setting $setting): Response
    {
        $form = $this->createForm(SettingType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Kayıt Güncelleme Başarılı');

            return $this->redirectToRoute('admin_setting_edit', ['id' => $setting->getId()]);
        }

        return $this->render('admin/setting/edit.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_setting_delete", methods="DELETE")
     */
    public function delete(Request $request, Setting $setting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$setting->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($setting);
            $em->flush();
        }

        return $this->redirectToRoute('admin_setting_index');
    }
}



