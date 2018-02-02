<?php

namespace AppBundle\EventListener;

use AppBundle\Service\RequestLogger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestLogSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestLogger
     */
    private $requestLogger;

    private $securityContext;

    public function __construct(RequestLogger $requestLogger, $security)
    {
        $this->requestLogger = $requestLogger;
        $this->securityContext = $security;
    }

    public function onKernelFinishRequest(FinishRequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->requestLogger->logRequest($event->getRequest());
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::FINISH_REQUEST => 'onKernelFinishRequest',
        ];
    }
}