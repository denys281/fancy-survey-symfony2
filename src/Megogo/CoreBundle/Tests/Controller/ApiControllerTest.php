<?php

namespace Megogo\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testSavestepone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/saveStepOne');
    }

    public function testRendersteptwo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/renderStepTwo');
    }

    public function testSavesteptwo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/saveStepTwo');
    }

    public function testRenderstepthree()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/renderStepThree');
    }

    public function testGetuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getUser');
    }

}
