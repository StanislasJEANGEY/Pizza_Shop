<?php

namespace pizzashop\shop\app\actions\get;

use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\CatalogueService;
use pizzashop\shop\domain\service\CommandeService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Commande extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $commandeService = new CommandeService();
        $catalogueService = new CatalogueService();
        $commande = $commandeService->accederCommande($args['id_commande'], $catalogueService);
        $data = [
            'id' => $commande->getIdCommande(),
            'date' => $commande->getDateCommande(),
            'prix' => $commande->getMontantCommande(),
            'statut' => $commande->getEtatCommande(),
            'items' => $commande->getItemsCommande()
        ];
        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $data = str_replace('\/', '/', $data);
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200);
    }
}