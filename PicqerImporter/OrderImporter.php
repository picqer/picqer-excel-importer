<?php
namespace PicqerImporter;

class OrderImporter {

    protected $picqerclient;
    protected $config;

    public function __construct($picqerclient, $config)
    {
        $this->picqerclient = $picqerclient;
        $this->config = $config;
    }

    public function importOrders($orders, $reference)
    {
        $orderids = array();
        foreach ($orders as $customerid => $products) {
            $orderids[] = $this->createOrder($customerid, $products, $reference);
        }

        return $orderids;
    }

    public function createOrder($customerid, $products, $reference)
    {
        $idcustomer = $this->getIdcustomer($customerid);
        $products = $this->changeProductcodeToIdproduct($products);

        $order = array(
            'idcustomer' => $idcustomer,
            'reference' => $reference,
            'products' => array()
        );

        foreach ($products as $idproduct => $amount) {
            $order['products'][] = array(
                'idproduct' => $idproduct,
                'amount' => $amount
            );
        }

        $result = $this->picqerclient->addOrder($order);
        if (isset($result['data']['idorder'])) {
            return $result['data']['orderid'];
        } else {
            throw new \Exception('Could not create order in Picqer');
        }
    }

    public function getIdcustomer($customerid)
    {
        $result = $this->picqerclient->getCustomerByCustomerid($customerid);
        if (isset($result['data']['idcustomer'])) {
            return $result['data']['idcustomer'];
        } else {
            throw new \Exception('Could not get matching idcustomer from Picqer');
        }
    }

    public function changeProductcodeToIdproduct($products)
    {
        $newProducts = array();

        foreach ($products as $productcode => $amount) {
            $productresult = $this->picqerclient->getProductByProductcode($productcode);
            if (isset($productresult['data'])) {
                $newProducts[$productresult['data']['idproduct']] = $amount;
            }
        }

        if (count($products) != count($newProducts)) {
            throw new \Exception('Could not get matching products from Picqer');
        }

        return $newProducts;
    }

}