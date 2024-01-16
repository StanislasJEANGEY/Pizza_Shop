<?php

namespace pizzashop\shop\app\actions\patch;

use Exception;
use GuzzleHttp\Exception\ClientException;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\app\actions\get\AccederCommande;
use pizzashop\shop\domain\service\CommandeService;
use pizzashop\shop\domain\service\iCatalogueService;
use pizzashop\shop\domain\service\iCommandeService;
use pizzashop\shop\Exception\BodyIncorrectException;
use pizzashop\shop\Exception\ServiceCommandeInvalideException;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use pizzashop\shop\Exception\ServiceValidatorException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\ValidationException;

class ValiderCommande extends AbstractAction
{
    private iCommandeService $commandeService;

    public function __construct(ContainerInterface $container, iCommandeService $s)
    {
        parent::__construct($container);
        $this->commandeService = $s;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $res = $this->requeteGuzzle('GET', $this->container->get('link_auth') . '/validate', $request);
            if ($res->getStatusCode() == 200){
                $body = $request->getBody();
                if ($body == "") {
                    $data = $this->exception(new BodyIncorrectException("Le body de la requête est vide", 400));
                    $status = 400;
                } else {
                    $body = json_decode($body, true);
                    if (!array_key_exists('etat', $body)) {
                        $data = $this->exception(new BodyIncorrectException("La clé 'etat' n'existe pas dans le body de la requête", 400));
                        $status = 400;
                    } else {
                        if ($body['etat'] != 'validée') {
                            $data = $this->exception(new BodyIncorrectException("La valeur de la clé 'etat' dans le body de la requête doit être 'validée' pour valider une commande", 400));
                            $status = 400;
                        } else {
                            $this->commandeService->validerCommande($args['id_commande']);
                            $data = AccederCommande::accederCommandeToJSON($args['id_commande'], $this->commandeService, $this->container);

                            $status = 200;
                        }
                    }
                }
                $data = $this->formatJSON($data);
            }
            $channel = $this->container->get('message.channel');
            $message = $this->container->get('message.message')->setBody($data);
            $channel->basic_publish($message, $this->container->get('message.exchange'), $this->container->get('message.routing_key'));
            $channel->close();

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