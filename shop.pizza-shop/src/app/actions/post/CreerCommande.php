<?php

namespace pizzashop\shop\app\actions\post;

use Exception;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\app\actions\get\AccederCommande;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\service\iCommandeService;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use pizzashop\shop\Exception\ServiceValidatorException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreerCommande extends AbstractAction
{

    private iCommandeService $commandeService;

    public function __construct(ContainerInterface $c, iCommandeService $s)
    {
        parent::__construct($c);
        $this->commandeService = $s;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $body = $request->getParsedBody();
        //TODO : créer les itemsDTO depuis les données en JSON dans le body et les ajouter dans le tableau $array_items

        //foreach element du tableau $body['items']

        $commandeDTO = new CommandeDTO("","", $body['type_livraison'], (int)null, (int)null, (float)null, $body['mail_client'], $array_items);

        $this->commandeService->creerCommande($commandeDTO);

        try {
            $data = AccederCommande::accederCommandeToJSON($args['id_commande'], $this->commandeService, $this->container);
            $status = 200;

        } catch (Exception $e) {
            $data = $this->exception($e);
            $status = $e->getCode();
        }
        $response->getBody()->write($data);

        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus($status);
    }
}