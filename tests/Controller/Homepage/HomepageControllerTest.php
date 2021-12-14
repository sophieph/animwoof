<?php

namespace App\Tests\Controller\Homepage;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Controller\Homepage\HomepageControllerTest;
use Symfony\Component\DependencyInjection\Loader\Configurator\request;

class HomepageControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Adoptez des animaux');
    }
}
