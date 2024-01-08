<?php

namespace pizzashop\shop\app\actions\get;

use Exception;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\iCatalogueService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListerProduitsParCategorie extends AbstractAction
{
    private iCatalogueService $catalogueService;

    public function __construct(ContainerInterface $container, iCatalogueService $s)
    {
        parent::__construct($container);
        $this->catalogueService = $s;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $this->listerProduitsParCategorieToJSON($this->catalogueService, $args['id_categorie']);
            $status = 200;
        } catch (Exception $e) {
            $data = $this->exception($e);
            $status = $e->getCode();
        }

        $data = $this->formatJSON($data);
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }

    public function listerProduitsParCategorieToJSON(iCatalogueService $service, int $idCategorie): array
    {
        $produits = $service->listerProduitsParCategorie($idCategorie);
        $array_produits = [];
        foreach ($produits as $produit) {
            $array_produits[] = [
                'libelle' => $produit->getLibelle(),
                'link' => $this->container->get('link') . "produits/" . $produit->getNumeroProduit()
            ];
        }
        return $array_produits;
    }
}