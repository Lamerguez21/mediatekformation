<?php

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of AdminCategoriesController
 *
 * @author Nathan Bengio
 */
class AdminCategoriesController extends AbstractController {

    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;
    
    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;
    
    
    function __construct(CategorieRepository $categorieRepository, FormationRepository $formationRespository) {
        $this->categorieRepository= $categorieRepository;
        $this->formationRepository = $formationRespository;
    }
    
    #[Route('/admin/categories', name: 'admin.categories')]
    public function index(): Response{
        $categories = $this->categorieRepository->findAll();
        return $this->render("pages/admin/admin.categories.html.twig", [
            'categories' => $categories
        ]);
    }
    
    #[Route('/admin/categories/suppr/{id}', name: 'admin.categories.suppr')]
    public function suppr(Categorie $categorie): Response {
        $test = $categorie->getFormations();
        if(count($test) == 0){
            $this->categorieRepository->remove($categorie, true);
            return $this->redirectToRoute('admin.categories');
        }
        $this->addFlash('error', 'La playlist contient des formations et ne peut pas être supprimée.');
        return $this->redirectToRoute('admin.categories');
    }
    
    #[Route('/admin/categories/ajout', name: 'admin.categories.ajout')]
    public function ajout(Request $request): Response{
        $name = $request->request->get("recherche");
        if(empty($name)){
            $this->addFlash('error', 'Le champ ne peut pas être vide');
            return $this->redirectToRoute('admin.categories');
        }
        $categorieExistante = $this->categorieRepository->findOneBy(['name' => $name]);
        if(!$categorieExistante){
            $categorie = new Categorie();
            $categorie->setName($name);
            $this->categorieRepository->add($categorie);
            return $this->redirectToRoute('admin.categories');
        }
        $this->addFlash('error', 'Cette catégorie existe déjà');
        return $this->redirectToRoute('admin.categories');
    }
}
