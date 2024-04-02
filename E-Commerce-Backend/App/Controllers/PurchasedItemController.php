<?php

namespace App\Controllers;

use App\DAO\PurchasedItemDAO;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

final class PurchasedItemController
{
    private PurchasedItemDAO $shoppingCartDAO;
    public function __construct(Container $container)
    {
        $this->shoppingCartDAO = $container->offsetGet(PurchasedItemDAO::class);
    }

    public function purchase(Request $request, Response $response, array $args): Response
    {
        try {
            # code...
        } catch (\Throwable $e) {
            # code...
        }
        return $response;
    }


}