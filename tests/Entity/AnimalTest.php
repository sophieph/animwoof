<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;
use App\Entity\Animal;
use App\Entity\Espece;



class AnimalTest extends TestCase
{
    public function testAge(): void
    {
        $animal = new Animal();
        $age = 3;
        
        $animal->setAge($age);
        $this->assertEquals(3, $animal->getAge());
    }

    public function testEntityFailure()
    {
        $espece = new Espece();
        $espece->setNom('oiseau');

        $this->assertInstanceOf(Espece::class, new Animal());
    }

    public function testEntity()
    {
        $espece = new Espece();
        $espece->setNom('oiseau');
        $espece->setCreatedAt(new \Datetime());

        $this->assertInstanceOf(Animal::class, new Animal());
    }

    public function testAgeRegExFailure()
    {
        $animal = new Animal();
        $animal->setNom('Coco');
        $animal->setCreatedAt(new \Datetime());
        $animal->setRace('Labrador');
        $animal->setAge('30');
        $animal->setPoids('30');
        $animal->setDateDeNaissance(new \Datetime());
        $animal->setDescription('Un petit chien qui aboie beaucoup');

        $this->assertMatchesRegularExpression('/^[0-9]$/', $animal->getAge());
    }

    public function testAgeRegEx()
    {
        $animal = new Animal();
        $animal->setNom('Coco');
        $animal->setRace('Labrador');
        $animal->setAge('13');
        $animal->setPoids('30');
        $animal->setDateDeNaissance(new \Datetime());
        $animal->setDescription('Un petit chien qui aboie beaucoup');

        $this->assertMatchesRegularExpression('/^[0-9][0-9]$/',  $animal->getAge());
    }

    public function testDescriptionNullFailure() {
        $animal = new Animal();
        $animal->setNom('Coco');
        $animal->setRace('Labrador');
        $animal->setAge('13');
        $animal->setPoids('30');
        $animal->setDateDeNaissance(new \Datetime());
        $animal->setDescription('Un petit chien qui aboie beaucoup');
        $this->assertNull($animal->getDescription());
    }

    public function testDescriptionNull() {
        $animal = new Animal();

        $this->assertNull($animal->getDescription());
    }

    public function testPoidsGreaterThan() {
        $animal = new Animal();
        $animal->setPoids('10');
        $animal->setNom('Coco');
        $animal->setRace('Labrador');
        $animal->setAge('13');
        $animal->setDateDeNaissance(new \Datetime());
        $animal->setDescription('Un petit chien qui aboie beaucoup');

        $this->assertGreaterThanOrEqual(0, $animal->getPoids());
    }

    public function testIsAdopted() {
        $animal = new Animal();
        $animal->setNom('Coco');
        $animal->setRace('Labrador');
        $animal->setAge('13');
        $animal->setDateDeNaissance(new \Datetime());
        $animal->setDescription('Un petit chien qui aboie beaucoup');
        $animal->setPoids('10');

        $this->assertFalse($animal->getIsAdopted());

    }

    public function testPoidsNanFailure() {
        $animal = new Animal();
        $animal->setPoids(44);

        $this->assertNan($animal->getPoids());
    }

    public function testPoidsNan() {
        $animal = new Animal();
        $animal->setPoids('rrr');

        $this->assertNan($animal->getPoids());
    }
}
