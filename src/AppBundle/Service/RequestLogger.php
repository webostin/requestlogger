<?php


namespace AppBundle\Service;


use AppBundle\Entity\RequestLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestLogger
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    protected $mailer;

    protected $sender;

    protected $templating;

    public function __construct(EntityManagerInterface $em, $mailer, $templating, $sender)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->sender = $sender;
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @param string $email
     */
    public function sendReport(\DateTime $from, \DateTime $to, $email)
    {
        $requestLogCount = $this->em
            ->getRepository('AppBundle:RequestLog')
            ->countRequests($from, $to);

        $message = (new \Swift_Message('Request log statistics'))
            ->setFrom($this->sender)
            ->setTo($email)
            ->setBody(
                $this->templating->render(
                    'AppBundle::emails/request_statistics.html.twig',
                    [
                        'dateFrom' => $from,
                        'dateTo' => $to,
                        'count' => $requestLogCount,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    /**
     * @param Request $request
     */
    public function logRequest(Request $request)
    {
        $queryParams = $request->query->all();
        $requestParams = $request->request->all();
        $files = $request->files->all();
        $httpReferer = $request->headers->get('referer');

        $requestLog = new RequestLog();
        if (!empty($files)) {
            $requestLog->setFileParams($files);
        }

        if (!empty($requestParams)) {
            $requestLog->setRequestParams($requestParams);
        }

        if (!empty($queryParams)) {
            $requestLog->setQueryParams($queryParams);
        }

        if (!empty($httpReferer)) {
            $requestLog->setHttpReferer($httpReferer);
        }

        $requestLog->setSessionId($request->getSession()->getId())
            ->setUrlRequest($request->getRequestUri())
            ->setIpAddress($request->getClientIp())
            ->setHttpMethod($request->getMethod());

        $this->em->persist($requestLog);
        $this->em->flush();
    }
}