<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Fichier;
use App\Form\FichierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\FichierRepository;
// use Doctrine\Common\Persistence\ObjetManager;

class FiletransController extends AbstractController
{
      /**
     * @Route("/filetrans", name="filetrans")
     */

    public function new(Request $request)
    {
      dump($request);
$Fichier = new Fichier();
$form = $this->createForm(FichierType::class, $Fichier);
$manager = $this->getDoctrine()->getManager();
      //-------------------------
if ($request->request->count() > 0) {
  $tableau = $request->request->get('fichier');
  $form->handleRequest($request);
   $Fichier->setDest($tableau['dest'])
           ->setExpd($request->request->get('fichier')['expd'])
           ->setNomdest($tableau['nomdest'])
           ->setNomfile($request->files->get('fichier')['nomfile']->getClientOriginalName());

   $manager->persist($Fichier);
   $manager->flush();
}

      return $this->render('filetrans/index.html.twig', [
            'formTransfer' => $form->createView(),
            //--------------------------------------------
        ]);
    }
}
