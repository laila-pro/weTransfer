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
$form->handleRequest($request);
$Fichier = new Fichier();
$form = $this->createForm(FichierType::class, $Fichier);
$manager = $this->getDoctrine()->getManager();
      //-------------------------
      // if ($form->isSubmitted() && $form->isValid()){
        $tableau = $request->request->get('fichier');
    dump($request);
if ($request->request->count() > 0) {

   $Fichier->setDest(filter_var(trim($tableau['dest']), FILTER_SANITIZE_EMAIL))
           ->setExpd(filter_var(trim($request->request->get('fichier')['expd']), FILTER_SANITIZE_EMAIL))
           ->setNomdest($tableau['nomdest'])
           ->setNomfile($request->files->get('fichier')['nomfile']->getClientOriginalName());
////insert into DB

   $manager->persist($Fichier);
   $manager->flush();
   /** @var UploadedFile $nomFile */
   $nomFile = $form['nomfile']->getData();
   if ($nomFile) {
                $originalFilename = pathinfo($nomFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$nomFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $nomFile->move(
                        $this->getParameter('files_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

// updates the 'brochureFilename' property to store the PDF file name
// instead of its contents
                $Fichier->setNomfile($newFilename);

                /////ZIP
                $zip = new ZipArchive();
                //donner un nom unique a mon fichier zip
                $filename = uniqid().'.zip';
                if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
                    exit("Impossible d'ouvrir le fichier <$filename>\n");
                }
                $zip->addFile($this->getParameter('files_directory').'/'.$newFilename);
 ////////// All files are added, so close the zip file./////////////
            $zip->close();
//////////////supprimer le fichier temporaire////////////
            unlink($this->getParameter('files_directory').'/'.$newFilename);
            }
//////////// Create the message ////////////
            $message = (new \Swift_Message())
              ->setSubject('EasyTransfer - Fichiers envoyés par ' . $Fichier->getNomdest())
              ->setFrom([$Fichier->getExpd()])
              ->setTo([$Fichier->getDest()]);

////////////////send mail///////////////////////
  // $cid = $message->embed(\Swift_Image::fromPath('img/logo.png'));
  $message->setBody(
            $this->renderView('filetrans/sendMail.html.twig', [
                'nomDestinataire' => $Fichier->getNomdest(),
                'nomAuteur' => $Fichier->getNomdest(),
                'link' => $filename
                // 'imgLogo' => $cid
            ]),
            'text/html'
          );
          $mailer->send($message);
          /////verifier la validation de l'adresse mail


// }
// dump("erreur");


}
      return $this->render('filetrans/index.html.twig', [
            'formTransfer' => $form->createView(),
        //     --------------------------------------------
        ]);

    }
}
