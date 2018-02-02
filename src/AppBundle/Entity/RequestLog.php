<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequestLog
 *
 * @ORM\Table(name="request_log")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RequestLogRepository")
 */
class RequestLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="session_id", type="string", length=255)
     */
    private $sessionId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=55)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="url_request", type="text")
     */
    private $urlRequest;

    /**
     * @var string
     *
     * @ORM\Column(name="request_params", type="text", nullable=true)
     */
    private $requestParams;

    /**
     * @var string
     *
     * @ORM\Column(name="query_params", type="text", nullable=true)
     */
    private $queryParams;

    /**
     * @var string
     *
     * @ORM\Column(name="http_method", type="string", length=10)
     */
    private $httpMethod;

    /**
     * @var string
     *
     * @ORM\Column(name="file_params", type="text", nullable=true)
     */
    private $fileParams;

    /**
     * @var string
     *
     * @ORM\Column(name="http_referer", type="text", nullable=true)
     */
    private $httpReferer;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sessionId
     *
     * @param string $sessionId
     * @return RequestLog
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     * @return RequestLog
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set urlRequest
     *
     * @param string $urlRequest
     * @return RequestLog
     */
    public function setUrlRequest($urlRequest)
    {
        $this->urlRequest = $urlRequest;

        return $this;
    }

    /**
     * Get urlRequest
     *
     * @return string
     */
    public function getUrlRequest()
    {
        return $this->urlRequest;
    }

    /**
     * Set requestParams
     *
     * @param array $requestParams
     * @return RequestLog
     */
    public function setRequestParams($requestParams)
    {
        $this->requestParams = json_encode($requestParams);

        return $this;
    }

    /**
     * Get requestParams
     *
     * @return array
     */
    public function getRequestParams()
    {
        return json_decode($this->requestParams, true);
    }

    /**
     * Set queryParams
     *
     * @param array $queryParams
     * @return RequestLog
     */
    public function setQueryParams($queryParams)
    {
        $this->queryParams = json_encode($queryParams);

        return $this;
    }

    /**
     * Get queryParams
     *
     * @return array
     */
    public function getQueryParams()
    {
        return json_decode($this->queryParams, true);
    }

    /**
     * Set httpMethod
     *
     * @param string $httpMethod
     * @return RequestLog
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;

        return $this;
    }

    /**
     * Get httpMethod
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Set fileParams
     *
     * @param array $fileParams
     * @return RequestLog
     */
    public function setFileParams($fileParams)
    {
        $this->fileParams = json_encode($fileParams);

        return $this;
    }

    /**
     * Get fileParams
     *
     * @return array
     */
    public function getFileParams()
    {
        return json_decode($this->fileParams, true);
    }

    /**
     * Set httpReferer
     *
     * @param string $httpReferer
     * @return RequestLog
     */
    public function setHttpReferer($httpReferer)
    {
        $this->httpReferer = $httpReferer;

        return $this;
    }

    /**
     * Get httpReferer
     *
     * @return string
     */
    public function getHttpReferer()
    {
        return $this->httpReferer;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }


}
