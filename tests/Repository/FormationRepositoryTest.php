<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationRepositoryTest
 *
 * @author Nathan Bengio
 */
class FormationRepositoryTest extends KernelTestCase {

    public function recupRepository(): FormationRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    public function testNbFormations(){
        $repository = $this->recupRepository();
        $nbFormations = $repository->count([]);
        $this->assertEquals(237, $nbFormations);
    }
    
    
    public function testAddFormation(){
        $repository = $this->recupRepository();
        $formation = new Formation();
        $nbFormations = $repository->count([]);
        $repository->add($formation, true);
        $this->assertEquals($nbFormations + 1, $repository->count([]), "erreur lors de l'ajout");
        $repository->remove($formation, true);        
    }
    
    public function testRemoveFormation(){
        $repository = $this->recupRepository();
        $formation = new Formation();
        $repository->add($formation, true);
        $nbFormations = $repository->count([]);
        $repository->remove($formation, true);
        $this->assertEquals($nbFormations - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
     public function testFindAllOrderBy(){
        $repository = $this->recupRepository();
        $formation = new Formation();
        $formation->setTitle("AAA");
        $repository->add($formation, true);
        $tri = $repository->findAllOrderBy('title', 'ASC');
        $this->assertEquals("AAA", $tri[0]->getTitle(), "erreur lors du tri");
        $repository->remove($formation, true);        
    }
    
    public function testfindByContainValue(){
        $repository = $this->recupRepository();
        $formation = new Formation();
        $formation->setTitle("nom_test");
        $repository->add($formation, true);
        $recherche = $repository->findByContainValue('title', 'nom_test');
        $this->assertEquals("nom_test", $recherche[0]->getTitle(), "erreur lors de la recherche");
        $repository->remove($formation, true);    
    }
    
    public function testFindAllLasted(){
        $repository = $this->recupRepository();
        $formation = new Formation();
        $formation->setPublishedAt(new \DateTime('today'));
        $repository->add($formation, true);
        $recherche = $repository->findAllLasted(1);
        $this->assertEquals(new \DateTime('today'), $recherche[0]->getPublishedAt(), "erreur lors de la récupération des dernières formations");
        $repository->remove($formation, true);
    }
    
    public function testfindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $recherche = $repository->findAllForOnePlaylist(21);
        $this->assertEquals(2, count($recherche), "erreur lors de la récupération des formations d'une playlist");
    }
}
