<?php

namespace pizzashop\shop\app\actions\post;

use Exception;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\app\actions\get\AccederCommande;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\commande\ItemDTO;
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
        $body = $request->getBody();
        //TODO : gérer les exceptions

        $body = json_decode($body, true);
        $array_items = [];
        foreach ($body['items'] as $item) {
            $array_items = new ItemDTO("",
                $item['numero'],
                $item['quantite'],
                (float)null,
                "",
                $item['taille'],
                "");
        }

        $commandeDTO = new CommandeDTO("","", $body['type_livraison'], (int)null, (int)null, (float)null, $body['mail_client'], (array)$array_items);


        try {
            $id = $this->commandeService->creerCommande($commandeDTO);
            $data = AccederCommande::accederCommandeToJSON($id, $this->commandeService, $this->container);
            $status = 201;

        } catch (Exception $e) {
            $data = $this->exception($e);
            $status = $e->getCode();
        }
        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $data = str_replace('\/', '/', $data);
        $response->getBody()->write($data);

        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus($status);
    }
}