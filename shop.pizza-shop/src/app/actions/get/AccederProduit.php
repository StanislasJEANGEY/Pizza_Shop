<?php

namespace pizzashop\shop\app\actions\get;

use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\Exception\ServiceCatalogueNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use pizzashop\shop\domain\service\CatalogueService;
use Slim\Exception\HttpNotFoundException;

class AccederProduit extends AbstractAction
{
    private CatalogueService $catalogueService;

    public function __construct(CatalogueService $catalogueService)
    {
        $this->catalogueService = $catalogueService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        try{
            $data = self::accederProduitToJSON($id, $this->catalogueService);
            $status = 200;
        }
        catch(\Exception $e){
            $data = $this->exception($e);
            $status = $e->getCode();
        }
        $data = $this->formatJSON($data);
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    /**
     * @throws ServiceCatalogueNotFoundException
     */
    public static function accederProduitToJSON(int $id, CatalogueService $service): array
    {
        $produit = $service->getProduitById($id);
        $data = [
            'id' => $produit->getNumeroProduit(),
            'libelle' => $produit->getLibelle(),
            'description' => $produit->getDescription(),
            'image' => $produit->getImage(),
            'categorie' => $produit->getLibelleCategorie(),
            'tailles' => $produit->getLibelleTaille(),
            'tarif' => $produit->getPrix()
        ];
        return $data;
    }
}