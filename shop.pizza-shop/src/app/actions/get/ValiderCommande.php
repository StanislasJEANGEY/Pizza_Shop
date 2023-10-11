<?php

namespace pizzashop\shop\app\actions\get;

use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\CommandeService;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ValiderCommande extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        //TODO finir exo 2 TD3
        $commandeService = new CommandeService();
        try {
            $commandeService->validerCommande($args['id_commande']);
        } catch (ServiceCommandeNotFoundException $e) {
            $data = $e->getMessage();
            $status = 404;
        } catch (\Exception $e) {
            $data = $e->getMessage();
            $status = 500;
        }
        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $data = str_replace('\/', '/', $data);

        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus($status);
    }
}