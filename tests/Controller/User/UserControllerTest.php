<?php

namespace App\Tests\Controller\User;

use App\Entity\Don;
use App\Entity\User;
use App\Repository\DonRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Loader\Configurator\request;

class UserControllerTest extends WebTestCase {
    
    public function testRepoUser(): void {
        
        $user = new User();
        $user->setId(1);
        $user->setEmail('test@test.com');
        $user->setPassword('toto');
        $user->setPseudo('Benjamin');

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->any())
        ->method('find')
        ->willReturn($user);

        $this->assertEquals(1, $user->getId());
    }

    public function testRepoDon(): void {
        
        $don = new Don();
        $don->setId(1);
        $don->setMontant(10);
        $don->setMessage('toto');

        $donRepository = $this->createMock(DonRepository::class);
        $donRepository->expects($this->any())
        ->method('find')
        ->willReturn($don);
        
        $this->assertEquals(1, $don->getId());
    }

}
