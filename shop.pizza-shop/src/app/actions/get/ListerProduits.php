<?php

namespace pizzashop\shop\app\actions\get;

use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\iCatalogueService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListerProduits extends AbstractAction
{
    private iCatalogueService $catalogueService;

    public function __construct(ContainerInterface $container, iCatalogueService $s)
    {
        parent::__construct($container);
        $this->catalogueService = $s;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try{
            $data = $this->listerProduitToJSON($this->catalogueService, $this->container);
            $status = 200;
        } catch (\Exception $e){
            $data = $this->exception($e);
            $status = $e->getCode();
        }
        $data = $this->formatJSON($data);
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    public function listerProduitToJSON(iCatalogueService $service, ContainerInterface $container): array
    {
        $produits = $service->listerProduits();
        $array_produits = [];
        foreach ($produits as $produit) {
            $array_produits[] = [
                'libelle' => $produit->getLibelle(),
                'link' => $container->get('link')."produits/".$produit->getNumeroProduit()
            ];
        }
        return $array_produits;
    }
}