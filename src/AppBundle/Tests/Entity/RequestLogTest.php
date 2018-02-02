<?php


namespace AppBundle\Tests\Entity;


use AppBundle\Entity\RequestLog;
use AppBundle\Tests\AbstractKernelTestCase;

class RequestLogTest extends AbstractKernelTestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('AppBundle\\Entity\\RequestLog'));
        $this->assertTrue(class_exists('AppBundle\\Repository\\RequestLogRepository'));
    }

    public function testCreateAndPersistLog()
    {

        $fileParams = ['tmp_file' => 'blbl.jpg', 'uploaded' => 'sdasd.jpg'];
        $requestParams = ['form' => ['data' => ['name' => 'Test']]];
        $queryParams = ['test' => 2];
        $httpReferer = 'http://previous.com';
        $urlRequest = 'http://final.com';
        $ipAddress = '127.0.0.1';
        $httpMethod = 'POST';
        $sessionId = '2343223423';

        $requestLog = new RequestLog();
        $requestLog->setHttpMethod($httpMethod)
            ->setIpAddress($ipAddress)
            ->setHttpReferer($httpReferer)
            ->setUrlRequest($urlRequest)
            ->setQueryParams($queryParams)
            ->setRequestParams($requestParams)
            ->setFileParams($fileParams)
            ->setSessionId($sessionId);

        $em = $this->getEnityManager();
        $em->persist($requestLog);
        $em->flush();

        $this->assertNotEmpty($requestLog->getId());

        $repo = $em->getRepository('AppBundle:RequestLog');
        $requestLogRetrieve = $repo->find($requestLog->getId());

        $this->assertTrue($requestLogRetrieve instanceof RequestLog);

        $this->assertEquals($requestLogRetrieve->getFileParams(), $fileParams);
        $this->assertEquals($requestLogRetrieve->getQueryParams(), $queryParams);
        $this->assertEquals($requestLogRetrieve->getHttpMethod(), $httpMethod);
        $this->assertEquals($requestLogRetrieve->getHttpReferer(), $httpReferer);
        $this->assertEquals($requestLogRetrieve->getIpAddress(), $ipAddress);
        $this->assertEquals($requestLogRetrieve->getRequestParams(), $requestParams);
        $this->assertEquals($requestLogRetrieve->getSessionId(), $sessionId);


    }
}