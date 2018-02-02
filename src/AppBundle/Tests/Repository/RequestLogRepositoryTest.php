<?php


namespace AppBundle\Tests\Repository;


use AppBundle\Entity\RequestLog;
use AppBundle\Tests\AbstractKernelTestCase;

class RequestLogRepositoryTest extends AbstractKernelTestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('AppBundle\\Entity\\RequestLog'));
        $this->assertTrue(class_exists('AppBundle\\Repository\\RequestLogRepository'));
    }

    public function testCountRequests()
    {
        $dateFrom = new \DateTime('- 3 months');
        $dateTo = new \DateTime('+ 2 minutes');

        $em = $this->getEnityManager();
        $repo = $em->getRepository('AppBundle:RequestLog');

        $counter1 = $repo->countRequests($dateFrom, $dateTo);

        $this->assertTrue(is_numeric($counter1));

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

        $em->persist($requestLog);
        $em->flush();

        $this->assertNotEmpty($requestLog->getId());


        $requestLogRetrieve = $repo->find($requestLog->getId());

        $this->assertTrue($requestLogRetrieve instanceof RequestLog);

        $this->assertEquals($requestLogRetrieve->getFileParams(), $fileParams);
        $this->assertEquals($requestLogRetrieve->getQueryParams(), $queryParams);
        $this->assertEquals($requestLogRetrieve->getHttpMethod(), $httpMethod);
        $this->assertEquals($requestLogRetrieve->getHttpReferer(), $httpReferer);
        $this->assertEquals($requestLogRetrieve->getIpAddress(), $ipAddress);
        $this->assertEquals($requestLogRetrieve->getRequestParams(), $requestParams);
        $this->assertEquals($requestLogRetrieve->getSessionId(), $sessionId);


        $counter2 = $repo->countRequests($dateFrom, $dateTo);

        $this->assertEquals($counter1 + 1, $counter2);

    }
}