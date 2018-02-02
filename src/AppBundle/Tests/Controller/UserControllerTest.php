<?php


namespace AppBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserControllerTest extends WebTestCase
{
    public function testForbiddenView()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/view');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testView()
    {
        $client = static::createClient();

        $credentials = $this->getBasicUserCredentials();
        $crawler = $client->request('GET', '/user/view', [], [], ['HTTP_AUTHORIZATION' => 'Basic ' . $credentials]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('This is user view', $crawler->filter('#user-view')->text());
    }

    public function testForbiddenCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/create');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testCreate()
    {
        $client = static::createClient();

        $credentials = $this->getBasicUserCredentials();
        $crawler = $client->request('GET', '/user/create', [], [], ['HTTP_AUTHORIZATION' => 'Basic ' . $credentials]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('This is user create', $crawler->filter('#user-create')->text());

        $extract = $crawler->filter('input[name="message_create[_token]"]')
            ->extract(['value']);
        $csrf_token = $extract[0];

        $photoPath = sprintf(
            '%s/../src/AppBundle/Tests/Resources/photo.jpg',
            $client->getContainer()->getParameter('kernel.root_dir')
        );

        $photo = new UploadedFile(
            $photoPath,
            'photo.jpg',
            'image/jpeg',
            123
        );
        $client->request(
            'POST',
            '/user/create',
            ['message_create' => [
                'content' => 'Test content',
                '_token' => $csrf_token,
            ],
            ],
            ['attachment' => $photo]
        );

        $crawler = $client->followRedirect();
        $this->assertContains('Your changes were saved!', $crawler->filter('#flash')->text());
    }

    private function getBasicUserCredentials()
    {
        return $credentials = base64_encode('user:test');
    }
}