<?php

namespace pizzashop\shop\app\actions\post;

use Exception;
use GuzzleHttp\Exception\ClientException;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\app\actions\get\AccederCommande;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\commande\ItemDTO;
use pizzashop\shop\domain\service\iCommandeService;
use pizzashop\shop\Exception\ServiceValidatorException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

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
        try {
            $res = $this->requeteGuzzle('GET', $this->container->get('link_auth') . '/validate', $request);
            if ($res->getStatusCode() == 200){
                $body = $request->getBody();
                try{
                    $body = json_decode($body, true);
                    $array_items = [];
                    foreach ($body['items'] as $item) {
                        $array_items[] = new ItemDTO("",
                            $item['numero'],
                            $item['quantite'],
                            (float)null,
                            "",
                            '',
                            $item['taille']);
                    }

                    $commandeDTO = new CommandeDTO("", "", $body['type_livraison'], (int)null, (int)null, (float)null, $body['mail_client'], $array_items);

                    $id = $this->commandeService->creerCommande($commandeDTO);
                    $data = AccederCommande::accederCommandeToJSON($id, $this->commandeService, $this->container);
                    $data = $this->formatJSON($data);
                    $status = 201;

                } catch (Exception $e) {
                    $data = $this->exception($e);
                    $status = $e->getCode();
                }
            }
        } catch (ClientException $e){
            $data = $e->getResponse()->getBody()->getContents();
            $status = $e->getResponse()->getStatusCode();

        }catch (Exception $e){
            $data = $this->exception($e);
            $status = $e->getCode();
            $data = $this->formatJSON($data);
        }
        $response->getBody()->write($data);

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($status);

    }
}