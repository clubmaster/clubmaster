<?php

namespace Club\Account\EconomicBundle\Helper;

class Economic
{
  public function __construct()
  {
    $this->economic_connect();
  }

  public function __destruct()
  {
    $this->economic_disconnect();
  }

  public function addEconomic($user,$order_number)
  {
    $cashbook = $this->addItem($user,$user->getProduct(),$order_number);

    foreach ($user->getItems() as $item) {
      $this->addItem($user,$item,$order_number,$cashbook->VoucherNumber);
    }
  }

  public function addCashBookEntry($product)
  {
    $parameters = $this->container->getParameter('economic');

    $cashbook = $this->client->CashBookEntry_CreateFinanceVoucher(array(
      'cashBookHandle' => $this->getCashBookByName($parameters['cashbook']),
      'accountHandle' => array('Number' => $product->getAccount()),
      'contraAccountHandle' => array('Number' => $parameters['contraAccount'])
    ))->CashBookEntry_CreateFinanceVoucherResult;

    return $this->getCashBookEntry($cashbook);
  }

  public function addItem($user,$product,$order_number,$voucherNumber=null)
  {
    $parameters = $this->container->getParameter('economic');

    $data = array(
      'CashBookHandle' => $this->getCashBookByName($parameters['cashbook']),
      'AccountHandle' => array('Number' => $product->getAccount()),
      'ContraAccountHandle' => array('Number' => $parameters['contraAccount']),
      'Type' => 'FinanceVoucher',
      'Date' => date('Y-m-d').'T00:00:00',
      'AmountDefaultCurrency' => $product->getPrice()*-1,
      'Amount' => $product->getPrice()*-1,
      'CurrencyHandle' => $this->getCurrencyByCode('DKK'),
      'Text' => '#'.$order_number.' - '.$user->getName()
    );

    if (!isset($voucherNumber)) {
      $cashbook = $this->addCashBookEntry($product);

      $data['Handle'] = array(
        'Id1' => $cashbook->Id1,
        'Id2' => $cashbook->Id2,
      );
      $data['VoucherNumber'] = $cashbook->VoucherNumber;

      $cashbook = $this->client->CashBookEntry_UpdateFromData(array(
        'data' => $data
      ))->CashBookEntry_UpdateFromDataResult;
    } else {
      $data['VoucherNumber'] = $voucherNumber;

      $cashbook = $this->client->CashBookEntry_CreateFromData(array(
        'data' => $data
      ))->CashBookEntry_CreateFromDataResult;
    }

    return $this->getCashBookEntry($cashbook);
  }

  public function getCashBookEntry($entry)
  {
    return $this->client->CashBookEntry_GetData(array(
      'entityHandle' => $entry
    ))->CashBookEntry_GetDataResult;
  }

  public function getNextNumber()
  {
    return $this->client->Entry_GetLastUsedSerialNumber()->Entry_GetLastUsedSerialNumberResult+1;
  }

  public function getAllCurrencies()
  {
    $currencies = $this->client->Currency_GetAll()->Currency_GetAllResult;

    return $currencies;
  }

  public function getCurrencyByCode($currency)
  {
    $curr = $this->client->Currency_FindByCode(array(
      'code' => $currency
    ))->Currency_FindByCodeResult;

    return $curr;
  }

  public function getCashBooks()
  {
    $cashbooks = $this->client->CashBook_GetAll();
    return $cashbooks;
  }

  public function getCashBookByName($name)
  {
    $cashbook = $this->client->CashBook_FindByName(array(
      'name' => $name
    ));
    return $cashbook->CashBook_FindByNameResult;
  }

  public function economic_connect()
  {
    $parameter = $this->container->getParameter('economic');

    $this->client = new \SoapClient($parameter['url'], array("trace" => 1, "exceptions" => 1));
    $this->client->Connect(array(
      'agreementNumber' => $parameter['agreement'],
      'userName'        => $parameter['user'],
      'password'        => $parameter['password']));
  }

  public function economic_disconnect()
  {
    $this->client->Disconnect();
  }
}
