<?php

namespace pizzashop\shop\app\actions\get;

use Exception;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\CommandeService;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccederCommande extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $commandeService = $this->conteneur->get('commande.service');

        try {
            $commande = $commandeService->accederCommande($args['id_commande']);
            $data = [
                'id' => $commande->getIdCommande(),
                'délai' => $commande->getDelaiCommande(),
                'date' => $commande->getDateCommande(),
                'type livraison' => $commande->getTypeLivraison(),
                'état' => $commande->getEtatCommande(),
                'montant' => $commande->getMontantCommande(),
                'mail client' => $commande->getMailClient(),
                'items' => $commande->getItemsCommande()
            ];
            $status = 200;

        } catch (ServiceCommandeNotFoundException $e){
            $data = $e->getMessage();
            $status = $e->getCode();
        } catch (Exception $e){
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
