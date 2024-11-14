<?php

namespace App\Controller\admin;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of PlaylistsController
 *
 * @author emds
 */
class AdminPlaylistsController extends AbstractController {

    // Chemin vers la page des playlists
    const ADRESSE = "pages/admin/admin.playlists.html.twig";

    /**
     * 
     * @var PlaylistRepository
     */
    private $playlistRepository;

    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;

    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;

    function __construct(PlaylistRepository $playlistRepository,
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository) {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }

    /**
     * @Route("/playlists", name="playlists")
     * @return Response
     */
    #[Route('admin/playlists', name: 'admin.playlists')]
    public function index(): Response {
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::ADRESSE, [
                    'playlists' => $playlists,
                    'categories' => $categories
         
        ]);
    }

    #[Route('admin/playlists/tri/{champ}/{ordre}', name: 'admin.playlists.sort')]
    public function sort($champ, $ordre): Response {
        switch($champ){
         case "name" :
            $playlists = $this->playlistRepository->findAllOrderByName($ordre);
            break;
         case "nb_formations":
            $playlists = $this->playlistRepository->findAllOrderByNbFormations($ordre);
            break;
          default :
             throw new \InvalidArgumentException("champ de tri non pris en charge");
        }    
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::ADRESSE, [
                    'playlists' => $playlists,
                    'categories' => $categories
        ]);
    }

    #[Route('admin/playlists/recherche/{champ}/{table}', name: 'admin.playlists.findallcontain')]
    public function findAllContain($champ, Request $request, $table = ""): Response {
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::ADRESSE, [
                    'playlists' => $playlists,
                    'categories' => $categories,
                    'valeur' => $valeur,
                    'table' => $table
        ]);
    }

    #[Route('admin/playlists/playlist/{id}', name: 'admin.playlists.showone')]
    public function showOne($id): Response {
        $playlist = $this->playlistRepository->find($id);
        $playlistCategories = $this->categorieRepository->findAllForOnePlaylist($id);
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        return $this->render("pages/playlist.html.twig", [
                    'playlist' => $playlist,
                    'playlistcategories' => $playlistCategories,
                    'playlistformations' => $playlistFormations
        ]);
    }
    
    #[Route('/admin/playlists/suppr/{id}', name: 'admin.playlist.suppr')]
    public function suppr(int $id, Playlist $playlist): Response {
        $nbFormations = $this->formationRepository->findAllForOnePlaylist($id);
        if(count($nbFormations) == 0){
            $this->playlistRepository->remove($playlist, true);
            return $this->redirectToRoute('admin.playlists');
        }
        $this->addFlash('error', 'La playlist contient des formations et ne peut pas être supprimée.');
        return $this->redirectToRoute('admin.playlists');
    }
    
    #[Route('/admin/playlists/edit/{id}', name: 'admin.playlist.edit')]
    public function edit(int $id, Request $request): Response {
        $playlist = $this->playlistRepository->find($id);
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        
        $formPlaylist->handleRequest($request);
        if ($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute('admin.playlists');
        }
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        return $this->render("pages/admin/admin.playlist.edit.html.twig", [
            'formplaylist' => $formPlaylist->createView(),
            'playlist' => $playlistFormations
        ]);
        }
        
    #[Route('/admin/playlists/ajout', name: 'admin.playlist.ajout')]
    public function ajout(Request $request): Response {
        $playlist = new Playlist();
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        
        $formPlaylist->handleRequest($request);
        if ($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute('admin.playlists');
        }
        return $this->render("pages/admin/admin.playlist.ajout.html.twig", [
            'formplaylist' => $formPlaylist->createView()
        ]);
        }
}
