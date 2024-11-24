<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Formation;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of FormationValidationsTest
 *
 * @author Nathan Bengio
 */
class FormationValidationsTest extends KernelTestCase{

    public function getFormation(): Formation{
        return (new Formation());
    }

    public function assertErrors(Formation $formation, int $nbErreursAttendues, string $message="") {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($formation);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    
    public function testValidDate(){
        $formation = $this->getFormation()->setPublishedAt(new DateTime("2024-04-28"));
        $this->assertErrors($formation, 0);
    }
    
    public function testNoValidDate(){
        $formation = $this->getFormation()->setPublishedAt(new DateTime('tomorrow'));
        $this->assertErrors($formation, 1, "date supérieure à celle du jour");
    }
}
