<?php

namespace App\Services\V2\ProductService;

use SDPMlab\Anser\Service\SimpleService;
use SDPMlab\Anser\Service\Action;
use Psr\Http\Message\ResponseInterface;
use SDPMlab\Anser\Exception\ActionException;
use SDPMlab\Anser\Service\ActionInterface;


class Inventory extends SimpleService
{

    protected $serviceName = "product_service";
    
    protected $retry      = 0;
    protected $retryDelay = 0.2;
    protected $timeout    = 6000.0;

    /**
     * 取得增加庫存 Action
     *
     * @param integer $productKey
     * @param string $orderKey
     * @param integer $addAmount
     * @param string $type
     * @return ActionInterface $action
     */
    public function addInventory(
        int $productKey,
        string $orderKey,
        int $addAmount,
        string $type
    ): ActionInterface {

        $payload = [
            "p_key"     => $productKey,
            "o_key"     => $orderKey,
            "addAmount" => $addAmount,
            "type"      => $type
        ];

        $action = $this->getAction("POST", "/api/v1/inventory/addInventory")
            ->addOption("form_params",$payload)
            ->doneHandler(function (
                ResponseInterface $response,
                Action $action
            ){
                $resBody = $response->getBody()->getContents();
                $data    = json_decode($resBody, true);
                $action->setMeaningData($data);
            })
            ->failHandler(function (
                ActionException $e
            ){
                if ($e->isServerError()) {
                    log_message('info',$e->getAction()->getResponse()->getBody()->getContents());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getAction()->getResponse()->getBody()->getContents()
                    ]);
                }else if ($e->isClientError()) {
                    log_message('info',$e->getAction()->getResponse()->getBody()->getContents());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getAction()->getResponse()->getBody()->getContents()
                    ]);
                }else if ($e->isConnectError()) {
                    log_message('info',$e->getMessage());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getMessage()
                    ]);
                }else {
                    log_message('error',$e->getMessage());
                    var_dump($e->getMessage());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getMessage()
                    ]);
                }
            });
        return $action;
    }

    /**
     * 取得減少庫存 Action
     *
     * @param integer $productKey
     * @param string $orderKey
     * @param integer $reduceAmount
     * @return ActionInterface $action
     */
    public function reduceInventory(
        int $productKey,
        string $orderKey,
        int $reduceAmount
    ): ActionInterface {

        $payload = [
            "p_key"         => $productKey,
            "o_key"         => $orderKey,
            "reduceAmount"  => $reduceAmount
        ];

        $action = $this->getAction("POST", "/api/v1/inventory/reduceInventory")
            ->addOption("form_params",$payload)
            ->doneHandler(function (
                ResponseInterface $response,
                Action $action
            ){
                $resBody = $response->getBody()->getContents();
                $data    = json_decode($resBody, true);
                $action->setMeaningData($data);
            })
            ->failHandler(function (
                ActionException $e
            ){
                if ($e->isServerError()) {
                    log_message('info',$e->getAction()->getResponse()->getBody()->getContents());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getAction()->getResponse()->getBody()->getContents()
                    ]);
                }else if ($e->isClientError()) {
                    log_message('info',$e->getAction()->getResponse()->getBody()->getContents());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getAction()->getResponse()->getBody()->getContents()
                    ]);
                }else if ($e->isConnectError()) {
                    log_message('info',$e->getMessage());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getMessage()
                    ]);
                }else {
                    log_message('error',$e->getMessage());
                    var_dump($e->getMessage());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getMessage()
                    ]);
                }
            });
        return $action;
    }

    /**
     * 取得刪除庫存 Action
     *
     * @param integer $productKey
     * @return ActionInterface $action
     */
    public function deleteInventory(int $productKey): ActionInterface
    {
        $action = $this->getAction("DELETE","/api/v1/inventory/{$productKey}")
            ->doneHandler(function(
                ResponseInterface $response,
                Action $action
            ){
                $resBody = $response->getBody()->getContents();
                $data = json_decode($resBody,true);
                $action->setMeaningData($data);
            })
            ->failHandler(function (
                ActionException $e
            ) {
                if ($e->isServerError()) {
                    log_message('info',$e->getAction()->getResponse()->getBody()->getContents());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getAction()->getResponse()->getBody()->getContents()
                    ]);
                }else if ($e->isClientError()) {
                    log_message('info',$e->getAction()->getResponse()->getBody()->getContents());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getAction()->getResponse()->getBody()->getContents()
                    ]);
                }else if ($e->isConnectError()) {
                    log_message('info',$e->getMessage());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getMessage()
                    ]);
                }else {
                    log_message('error',$e->getMessage());
                    var_dump($e->getMessage());
                    $e->getAction()->setMeaningData([
                        "code" => 500,
                        "msg" => $e->getMessage()
                    ]);
                }
            });
        return $action;
    }
    
}
