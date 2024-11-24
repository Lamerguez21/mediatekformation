<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author Nathan Bengio
 */
class PlaylistRepositoryTest extends KernelTestCase{

    public function recupRepository(): PlaylistRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
    
    public function testAddPlaylist(){
        $repository = $this->recupRepository();
        $playlist = new Playlist();
        $nbPlaylist = $repository->count([]);
        $repository->add($playlist, true);
        $this->assertEquals($nbPlaylist + 1, $repository->count([]), "erreur lors de l'ajout");
        $repository->remove($playlist, true);
    }
    
    public function testRemovePlaylist(){
        $repository = $this->recupRepository();
        $playlist = new Playlist();
        $repository->add($playlist, true);
        $nbPlaylists = $repository->count([]);
        $repository->remove($playlist, true);
        $this->assertEquals($nbPlaylists - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindAllOrderByName(){
        $repository = $this->recupRepository();
        $Playlist = new Playlist();
        $Playlist->setName("AAA");
        $repository->add($Playlist, true);
        $tri = $repository->findAllOrderByName('ASC');
        $this->assertEquals("AAA", $tri[0]->getName(), "erreur lors du tri");
        $repository->remove($Playlist, true);
    }
    
    public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $Playlist = new Playlist();
        $Playlist->setName("nom_test");
        $repository->add($Playlist, true);
        $recherche = $repository->findByContainValue('name', 'nom_test');
        $this->assertEquals("nom_test", $recherche[0]->getName(), "erreur lors de la recherche");
        $repository->remove($Playlist, true);
    }
    
    public function testFindAllOrderByNbFormations(){
        $repository = $this->recupRepository();
        $test = $repository->findAllOrderByNbFormations('DESC');
        $this->assertEquals("Bases de la programmation (C#)", $test[0]->getName(), "erreur lors du tri");
    }
}
