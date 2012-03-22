<?php

namespace Club\Account\EconomicBundle\Helper;

class Economic
{
  protected $container;

  public function __construct($container)
  {
    $this->container = $container;

    $this->connect();
  }

  function findDebtor($number)
  {
    $this->debtor = $this->client->Debtor_FindByNumber(array('number' => $number))->Debtor_FindByNumberResult;
    return $this->debtor;
  }

  function updateDebtor($number, $name, $email, $phone)
  {
    $data = array(
      'Handle' => array('Number' => $number),
      'VatZone' => 'HomeCountry',
      'Name' => $name,
      'Email' => $email,
      'TelephoneAndFaxNumber' => $phone,
      'DebtorGroupHandle' => array('Number' => 1),
      'CurrencyHandle' => array('Code' => 'DKK'),
      'TermOfPaymentHandle' => array('Id' => 1),
      'IsAccessible' => true,
      'LayoutHandle' => array('Id' => 16),
    );

    $this->debtor = $this->client->Debtor_UpdateFromData(array('data' => $data))->Debtor_UpdateFromDataResult;
  }

  function addDebtor($number, $name, $email)
  {
    $data = array(
      'VatZone' => 'HomeCountry',
      'Number' => $number,
      'Name' => $name,
      'Email' => $email,
      'DebtorGroupHandle' => array('Number' => 1),
      'CurrencyHandle' => array('Code' => 'DKK'),
      'TermOfPaymentHandle' => array('Id' => 1),
      'IsAccessible' => true,
      'LayoutHandle' => array('Id' => 16),
    );

    $this->debtor = $this->client->Debtor_CreateFromData(array('data' => $data))->Debtor_CreateFromDataResult;
  }

  function addOrder($order_number, $debtor_number, $name)
  {
    $data = array(
      'Number' => $order_number,
      'DebtorHandle' => array('Number' => $debtor_number),
      'DebtorName' => $name,
      'TermOfPaymentHandle' => array('Id' => 1),
      'Date' => date('Y-m-d').'T00:00:00',
      'DueDate' => date('Y-m-d').'T00:00:00',
      'ExchangeRate' => 1,
      'IsVatIncluded' => true,
      'DeliveryDate' => date('Y-m-d').'T00:00:00',
      'IsArchived' => false,
      'CurrencyHandle' => array('Code' => 'DKK'),
      'IsSent' => false,
      'NetAmount' => 0,
      'VatAmount' => 0,
      'GrossAmount' => 0,
      'Margin' => 0,
      'MarginAsPercent' => 0,
    );

    $this->order = $this->client->Order_CreateFromData(array(
      'data' => $data
    ))->Order_CreateFromDataResult;
  }

  function addOrderItem($item_number, $quantity, $name, $unit_price)
  {
    $data = array(
      'OrderHandle' => $this->order,
      'Number' => $item_number,
      'DeliveryDate' => date('Y-m-d').'T00:00:00',
      'Quantity' => $quantity,
      'ProductHandle' => array('Number' => 120),
      'Description' => $name,
      'UnitHandle' => array('Number' => 1),
      'UnitNetPrice' => $unit_price,
      'DiscountAsPercent' => 0,
      'UnitCostPrice' => 0,
      'TotalNetAmount' => ($unit_price*$quantity),
      'TotalMargin' => 0,
      'MarginAsPercent' => 0
    );


    $item = $this->client->OrderLine_CreateFromData(array(
      'data' => $data
    ))->OrderLine_CreateFromDataResult;
    $this->order_items[] = $item;
  }

  function getOrder()
  {
    return $this->order;
  }

  function findOrder($number)
  {
    $this->order = $this->client->Order_FindByNumber(array('number' => $number));
    return $this->order;
  }

  function getOrderNumber()
  {
    return $this->client->Order_GetNumber(array('orderHandle' => $this->order))->Order_GetNumberResult;
  }

  function upgradeOrder()
  {
    $item = $this->client->OrderLine_CreateFromData(array(
      'data' => $data
    ))->OrderLine_CreateFromDataResult;

  }

  public function __destruct()
  {
    $this->disconnect();
  }

  public function addEconomic($user,$order_number)
  {
    $cashbook = $this->addItem($user,$user->getProduct(),$order_number);

    foreach ($user->getItems() as $item) {
      $this->addItem($user,$item,$order_number,$cashbook->VoucherNumber);
    }
  }

  public function addCashBookEntry(\Club\ShopBundle\Entity\PurchaseLog $purchase_log)
  {
    $cashbook = $this->client->CashBookEntry_CreateFinanceVoucher(array(
      'cashBookHandle' => $this->getCashBookByName($this->container->getParameter('club_account_economic.cashbook')),
      'accountHandle' => array('Number' => $product->getAccountNumber()),
      'contraAccountHandle' => array('Number' => $this->container->getParameter('club_account_economic.contraAccount'))
    ))->CashBookEntry_CreateFinanceVoucherResult;

    return $this->getCashBookEntry($cashbook);
  }

  public function addItem(\Club\UserBundle\Entity\User $user,$product,$order_number,$voucherNumber=null)
  {
    $data = array(
      'CashBookHandle' => $this->getCashBookByName($this->container->getParameter('club_account_economic.cashbook')),
      'AccountHandle' => array('Number' => $product->getAccount()),
      'ContraAccountHandle' => array('Number' => $this->container->getParameter('club_account_economic.contraAccount')),
      'Type' => 'FinanceVoucher',
      'Date' => date('Y-m-d').'T00:00:00',
      'AmountDefaultCurrency' => $product->getPrice()*-1,
      'Amount' => $product->getPrice()*-1,
      'CurrencyHandle' => $this->getCurrencyByCode($this->container->getParameter('club_account_economic.currency')),
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

  public function connect()
  {
    $this->client = new \SoapClient($this->container->getParameter('club_account_economic.economic_url'), array("trace" => 1, "exceptions" => 1));
    $this->client->Connect(array(
      'agreementNumber' => $this->container->getParameter('club_account_economic.agreement'),
      'userName'        => $this->container->getParameter('club_account_economic.user'),
      'password'        => $this->container->getParameter('club_account_economic.password')
    ));
  }

  public function disconnect()
  {
    $this->client->Disconnect();
  }
}
