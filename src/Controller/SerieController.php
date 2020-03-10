<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SerieController extends AbstractController
{
    /**
     * @Route("/serie", name="serie")
     */
    public function index(SerieRepository $repo)
    {
        $series = $repo->findAll();

        return $this->render('serie/index.html.twig', [
            'series' => $series,
        ]);
    }

    /**
     * @Route("/_serie_table", name="_serie_table")
     */
    public function table(SerieRepository $repo)
    {
        $series = $repo->findAll();

        return $this->render('serie/_serie_table.html.twig',[
            'series' => $series,
        ]);
    }

    /**
     * @Route("/serie/new", name="serie_new")
     * @Route("/serie/edit/{id}", name="serie_edit")
     */
    public function new(Serie $serie = null,Request $request)
    {
        if ($serie == null) {
            $serie = new Serie();
        }
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $fichier = $form->get('image')->getData();
            //Si un fichier a été uploadé
            if ($fichier) {
                // On renomme le fichier
                $nomFicher = uniqid() . '.' . $fichier->guessExtension();
                try {
                    // on essaie de deplacer le fichier
                    $fichier->move(
                        $this->getParameter('upload_dir'),
                        $nomFicher
                    );
                } catch (FileExeption $e) {
                    $this->addFlash('danger', "Impossible d'uploader le fichier");
                    return $this->redirectToRoute('serie');
                }
                $serie->setImage($nomFicher);
            }
            $manager->persist($serie);
            $manager->flush();
            $this->addFlash("success","Série ajouté");
        }
        
        
        

       return $this->render('serie/serie_new.html.twig',[
           "formSerie" => $form->createView(),
           'editTitle' => $serie->getId() != null,
            'editMode' => $serie->getId() != null
       ]); 
    }

    /**
     * @Route("/serie/delete/{id}",name="serie_delete")
     */
    public function delete(Serie $serie = null)
    {
        if ($serie != null) {
            $manager = $this->getDoctrine()->getManager();
            $serie->getImage();
            $manager->remove($serie);
            $manager->flush();

            $this->addFlash("success","Série supprimée");
        }
        else {
            $this->addFlash("danger","Série introuvable");
        }
        return $this->redirectToRoute('serie');
    }

    /**
     * @Route("/serie/{id}",name="serie_detail")
     */
    public function detail($id,SerieRepository $repo)
    {
        $serie = $repo->find($id);

        return $this->render('serie/serie_detail.html.twig',[
            'serie' => $serie,
        ]);
    }
}