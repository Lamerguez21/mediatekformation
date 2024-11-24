<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of CategorieRepositoryTest
 *
 * @author Nathan Bengio
 */
class CategorieRepositoryTest extends KernelTestCase {
public function recupRepository(): CategorieRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    public function testAddCategorie(){
        $repository = $this->recupRepository();
        $Categorie = new Categorie();
        $nbCategorie = $repository->count([]);
        $repository->add($Categorie, true);
        $this->assertEquals($nbCategorie + 1, $repository->count([]), "erreur lors de l'ajout");
        $repository->remove($Categorie, true);
    }
    
    public function testRemoveCategorie(){
        $repository = $this->recupRepository();
        $Categorie = new Categorie();
        $repository->add($Categorie, true);
        $nbCategorie = $repository->count([]);
        $repository->remove($Categorie, true);
        $this->assertEquals($nbCategorie - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $recherche = $repository->findAllForOnePlaylist(14);
        $this->assertEquals("SQL", $recherche[0]->getName(), "erreur lors de la récupération des catégories d'une playlist");
    }
}
