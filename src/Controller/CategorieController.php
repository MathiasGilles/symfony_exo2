<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
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
}
