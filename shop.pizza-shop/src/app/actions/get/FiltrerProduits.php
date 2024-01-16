<?php

namespace pizzashop\shop\app\actions\get;

use Exception;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\iCatalogueService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use pizzashop\shop\domain\service\CatalogueService;

class FiltrerProduits extends AbstractAction
{
    private CatalogueService $catalogueService;

    public function __construct(ContainerInterface $container, iCatalogueService $s)
    {
        parent::__construct($container);
        $this->catalogueService = $s;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $motCle = $args['keyword'];

        try {
            $data = $this->filtrerProduitToJSON($this->catalogueService, $this->container, $motCle);
            $status = 200;
        } catch (Exception $e) {
            $data = $this->exception($e);
            $status = $e->getCode();
        }
        $data = $this->formatJSON($data);
        $response->getBody()->write($data);

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    public function filtrerProduitToJSON(iCatalogueService $service, ContainerInterface $container, $motCle): array
    {
        $produits = $service->filtrerProduitsParMotCle($motCle);
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