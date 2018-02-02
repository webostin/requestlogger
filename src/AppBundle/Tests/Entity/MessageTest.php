<?php


namespace AppBundle\Tests\Entity;


use AppBundle\Entity\Message;
use AppBundle\Tests\AbstractKernelTestCase;

class MessageTest extends AbstractKernelTestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('AppBundle\\Entity\\Message'));
        $this->assertTrue(class_exists('AppBundle\\Repository\\MessageRepository'));
    }

    public function testCreateAndPersistMessage()
    {
        $message = new Message();
        $message->setContent('test content')->setUser('test');

        $em = $this->getEnityManager();

        $em->persist($message);
        $em->flush();

        $this->assertNotEmpty($message->getId());

        $repo = $em->getRepository('AppBundle:Message');
        $messageRetrieved = $repo->find($message->getId());

        $this->assertTrue($messageRetrieved instanceof Message);
        $this->assertEquals($messageRetrieved->getContent(), 'test content');
        $this->assertEquals($messageRetrieved->getUser(), 'test');

    }
}