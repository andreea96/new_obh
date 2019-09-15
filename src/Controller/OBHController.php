<?php


namespace App\Controller;


use App\Service\FinqwareService;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

class OBHController extends AbstractFOSRestController
{
    private $service;

    public function __construct(FinqwareService $service)
    {
        $this->service = $service;
    }

    /**
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getAuthSessionAction()
    {
        dd('test');
        $view = $this->view($this->service->getErsteEnhancedAuthSession(), Response::HTTP_OK);

        return $this->handleView($view->setContext((new Context())->setGroups(['Default'])));
    }
}