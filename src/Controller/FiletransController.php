<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Fichier;
use ZipArchive;
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

    public function new(Request $request, \Swift_Mailer $mailer)
    {

$Fichier = new Fichier();
$form = $this->createForm(FichierType::class, $Fichier);
$manager = $this->getDoctrine()->getManager();
      //-------------------------
      // if ($form->isSubmitted() && $form->isValid()){
        $tableau = $request->request->get('fichier');
    if($this->CheckEmail($request->request->get('expd')) && $this->CheckEmail($request->request->get('dest'))){
dump($request);
if ($request->request->count() > 0) {
  $form->handleRequest($request);
   $Fichier->setDest(filter_var(trim($tableau['dest']), FILTER_SANITIZE_EMAIL))
           ->setExpd(filter_var(trim($request->request->get('fichier')['expd']), FILTER_SANITIZE_EMAIL))
           ->setNomdest($tableau['nomdest'])
           ->setNomfile($request->files->get('fichier')['nomfile']->getClientOriginalName());
   $manager->persist($Fichier);
   $manager->flush();
 }
 }
// }
      return $this->render('filetrans/index.html.twig', [
            'formTransfer' => $form->createView(),
            //--------------------------------------------
        ]);
    }
}
