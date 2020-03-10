<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(CategorieRepository $repo)
    {

        $categories = $repo->findAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/_categorie_table", name="_categorie_table")
     */
    public function table(CategorieRepository $repo)
    {
        $categories = $repo->findAll();

        return $this->render('categorie/_categorie_table.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/categorie/new",name="categorie_new")
     * @Route("/categorie/edit/{id}",name="categorie_edit")
     */
    public function new(Categorie $categorie = null,Request $request)
    {
         if ($categorie == null) {
            $categorie = new Categorie();
        }
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);
            $manager->flush();
            $this->addFlash("success","Categorie enregistrée");
        }
        
       return $this->render('categorie/categorie_new.html.twig',[
           'formCategorie' => $form->createView(),
           'editTitle' => $categorie->getId() != null,
            'editMode' => $categorie->getId() != null,
       ]); 
    }

    /**
     * @Route("/categorie/delete/{id}",name="categorie_delete")
     */
    public function delete(Categorie $categorie = null)
    {
        if($categorie != null){
            $manager=$this->getDoctrine()->getManager();
            $manager->remove($categorie);
            $manager->flush();

            $this->addFlash("success","Categorie supprimée");
        }
        else {
            $this->addFlash("danger","Categorie introuvable");
        }
        return $this->redirectToRoute('/');
    }

    /**
     * @Route("/categorie/detail/{id}",name="categorie_detail")
     */
    public function detail($id,CategorieRepository $repo){

        $categorie = $repo->find($id);

        return $this->render('categorie/categorie_detail.html.twig',[
            'categorie' => $categorie,
        ]);
    }
}
