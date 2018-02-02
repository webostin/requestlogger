<?php


namespace AppBundle\Tests\Service;


use AppBundle\Service\RequestLogger;
use AppBundle\Tests\AbstractKernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class RequestLoggerTest extends AbstractKernelTestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('AppBundle\\Service\\RequestLogger'));
    }

    public function testLogRequest()
    {
        $requestLogger = $this->getContainer()->get('app.request_logger');

        $this->assertTrue($requestLogger instanceof RequestLogger);

        $fakeRequest = Request::create('http://final.com', 'GET');
        $session = new Session();
        $fakeRequest->setSession($session);

        $requestLogger->logRequest($fakeRequest);

    }

    public function testSendReport()
    {
        $dateFrom = new \DateTime('- 10 minutes');
        $dateTo = new \DateTime('now');

        $requestLogger = $this->getContainer()->get('app.request_logger');
        $this->assertTrue($requestLogger instanceof RequestLogger);

        $requestLogger->sendReport($dateFrom, $dateTo, 'example@email.com');
    }
}