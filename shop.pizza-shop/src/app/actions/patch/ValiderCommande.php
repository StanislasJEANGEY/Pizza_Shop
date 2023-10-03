<?php

namespace pizzashop\shop\app\actions\patch;

use Exception;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\CommandeService;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\ValidationException;

class ValiderCommande extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $idCommande = $args['id-commande'];
        try {
            $commandeService = new CommandeService();
            $commande = $commandeService->validerCommande($idCommande);
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
        } catch (ServiceCommandeNotFoundException $e) {
            $response->getBody()->write(json_encode(["message" => "Commande introuvable"], JSON_PRETTY_PRINT));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        } catch (ValidationException $e) {
            $response->getBody()->write(json_encode(["message" => "La commande est déjà validée"], JSON_PRETTY_PRINT));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(["message" => "Erreur interne du serveur"], JSON_PRETTY_PRINT));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200);
    }
}