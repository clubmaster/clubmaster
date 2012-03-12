<?php

namespace Club\Payment\QuickpayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\Payment\QuickpayBundle\Entity\Transaction
 *
 * @ORM\Table(name="club_payment_quickpay_transaction")
 * @ORM\Entity(repositoryClass="Club\Payment\QuickpayBundle\Entity\TransactionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Transaction
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $msgtype
     *
     * @ORM\Column(name="msgtype", type="string", length=255)
     */
    private $msgtype;

    /**
     * @var string $ordernumber
     *
     * @ORM\Column(name="ordernumber", type="string", length=255)
     */
    private $ordernumber;

    /**
     * @var string $amount
     *
     * @ORM\Column(name="amount", type="string", length=255)
     */
    private $amount;

    /**
     * @var string $currency
     *
     * @ORM\Column(name="currency", type="string", length=255)
     */
    private $currency;

    /**
     * @var string $time
     *
     * @ORM\Column(name="time", type="string", length=255)
     */
    private $time;

    /**
     * @var string $state
     *
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;

    /**
     * @var string $qpstat
     *
     * @ORM\Column(name="qpstat", type="string", length=255)
     */
    private $qpstat;

    /**
     * @var string $qpstatmsg
     *
     * @ORM\Column(name="qpstatmsg", type="string", length=255)
     */
    private $qpstatmsg;

    /**
     * @var string $chstat
     *
     * @ORM\Column(name="chstat", type="string", length=255)
     */
    private $chstat;

    /**
     * @var string $chstatmsg
     *
     * @ORM\Column(name="chstatmsg", type="string", length=255)
     */
    private $chstatmsg;

    /**
     * @var string $merchant
     *
     * @ORM\Column(name="merchant", type="string", length=255)
     */
    private $merchant;

    /**
     * @var string $merchantemail
     *
     * @ORM\Column(name="merchantemail", type="string", length=255)
     */
    private $merchantemail;

    /**
     * @var string $transaction
     *
     * @ORM\Column(name="transaction", type="string", length=255)
     */
    private $transaction;

    /**
     * @var string $cardtype
     *
     * @ORM\Column(name="cardtype", type="string", length=255)
     */
    private $cardtype;

    /**
     * @var string $cardnumber
     *
     * @ORM\Column(name="cardnumber", type="string", length=255)
     */
    private $cardnumber;

    /**
     * @var string $cardexpire
     *
     * @ORM\Column(name="cardexpire", type="string", length=255)
     */
    private $cardexpire;

    /**
     * @var string $splitpayment
     *
     * @ORM\Column(name="splitpayment", type="string", length=255)
     */
    private $splitpayment;

    /**
     * @var string $fraudprobability
     *
     * @ORM\Column(name="fraudprobability", type="string", length=255)
     */
    private $fraudprobability;

    /**
     * @var string $fraudremarks
     *
     * @ORM\Column(name="fraudremarks", type="string", length=255)
     */
    private $fraudremarks;

    /**
     * @var string $fraudreport
     *
     * @ORM\Column(name="fraudreport", type="string", length=255)
     */
    private $fraudreport;

    /**
     * @var string $fee
     *
     * @ORM\Column(name="fee", type="string", length=255)
     */
    private $fee;

    /**
     * @var string $md5check
     *
     * @ORM\Column(name="md5check", type="string", length=255)
     */
    private $md5check;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set msgtype
     *
     * @param string $msgtype
     */
    public function setMsgtype($msgtype)
    {
        $this->msgtype = $msgtype;
    }

    /**
     * Get msgtype
     *
     * @return string
     */
    public function getMsgtype()
    {
        return $this->msgtype;
    }

    /**
     * Set ordernumber
     *
     * @param string $ordernumber
     */
    public function setOrdernumber($ordernumber)
    {
        $this->ordernumber = $ordernumber;
    }

    /**
     * Get ordernumber
     *
     * @return string
     */
    public function getOrdernumber()
    {
        return $this->ordernumber;
    }

    /**
     * Set amount
     *
     * @param string $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set currency
     *
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set time
     *
     * @param string $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set state
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set qpstat
     *
     * @param string $qpstat
     */
    public function setQpstat($qpstat)
    {
        $this->qpstat = $qpstat;
    }

    /**
     * Get qpstat
     *
     * @return string
     */
    public function getQpstat()
    {
        return $this->qpstat;
    }

    /**
     * Set qpstatmsg
     *
     * @param string $qpstatmsg
     */
    public function setQpstatmsg($qpstatmsg)
    {
        $this->qpstatmsg = $qpstatmsg;
    }

    /**
     * Get qpstatmsg
     *
     * @return string
     */
    public function getQpstatmsg()
    {
        return $this->qpstatmsg;
    }

    /**
     * Set chstat
     *
     * @param string $chstat
     */
    public function setChstat($chstat)
    {
        $this->chstat = $chstat;
    }

    /**
     * Get chstat
     *
     * @return string
     */
    public function getChstat()
    {
        return $this->chstat;
    }

    /**
     * Set chstatmsg
     *
     * @param string $chstatmsg
     */
    public function setChstatmsg($chstatmsg)
    {
        $this->chstatmsg = $chstatmsg;
    }

    /**
     * Get chstatmsg
     *
     * @return string
     */
    public function getChstatmsg()
    {
        return $this->chstatmsg;
    }

    /**
     * Set merchant
     *
     * @param string $merchant
     */
    public function setMerchant($merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * Get merchant
     *
     * @return string
     */
    public function getMerchant()
    {
        return $this->merchant;
    }

    /**
     * Set merchantemail
     *
     * @param string $merchantemail
     */
    public function setMerchantemail($merchantemail)
    {
        $this->merchantemail = $merchantemail;
    }

    /**
     * Get merchantemail
     *
     * @return string
     */
    public function getMerchantemail()
    {
        return $this->merchantemail;
    }

    /**
     * Set transaction
     *
     * @param string $transaction
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get transaction
     *
     * @return string
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Set cardtype
     *
     * @param string $cardtype
     */
    public function setCardtype($cardtype)
    {
        $this->cardtype = $cardtype;
    }

    /**
     * Get cardtype
     *
     * @return string
     */
    public function getCardtype()
    {
        return $this->cardtype;
    }

    /**
     * Set cardnumber
     *
     * @param string $cardnumber
     */
    public function setCardnumber($cardnumber)
    {
        $this->cardnumber = $cardnumber;
    }

    /**
     * Get cardnumber
     *
     * @return string
     */
    public function getCardnumber()
    {
        return $this->cardnumber;
    }

    /**
     * Set cardexpire
     *
     * @param string $cardexpire
     */
    public function setCardexpire($cardexpire)
    {
        $this->cardexpire = $cardexpire;
    }

    /**
     * Get cardexpire
     *
     * @return string
     */
    public function getCardexpire()
    {
        return $this->cardexpire;
    }

    /**
     * Set splitpayment
     *
     * @param string $splitpayment
     */
    public function setSplitpayment($splitpayment)
    {
        $this->splitpayment = $splitpayment;
    }

    /**
     * Get splitpayment
     *
     * @return string
     */
    public function getSplitpayment()
    {
        return $this->splitpayment;
    }

    /**
     * Set fraudprobability
     *
     * @param string $fraudprobability
     */
    public function setFraudprobability($fraudprobability)
    {
        $this->fraudprobability = $fraudprobability;
    }

    /**
     * Get fraudprobability
     *
     * @return string
     */
    public function getFraudprobability()
    {
        return $this->fraudprobability;
    }

    /**
     * Set fraudremarks
     *
     * @param string $fraudremarks
     */
    public function setFraudremarks($fraudremarks)
    {
        $this->fraudremarks = $fraudremarks;
    }

    /**
     * Get fraudremarks
     *
     * @return string
     */
    public function getFraudremarks()
    {
        return $this->fraudremarks;
    }

    /**
     * Set fraudreport
     *
     * @param string $fraudreport
     */
    public function setFraudreport($fraudreport)
    {
        $this->fraudreport = $fraudreport;
    }

    /**
     * Get fraudreport
     *
     * @return string
     */
    public function getFraudreport()
    {
        return $this->fraudreport;
    }

    /**
     * Set fee
     *
     * @param string $fee
     */
    public function setFee($fee)
    {
        $this->fee = $fee;
    }

    /**
     * Get fee
     *
     * @return string
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Set md5check
     *
     * @param string $md5check
     */
    public function setMd5check($md5check)
    {
        $this->md5check = $md5check;
    }

    /**
     * Get md5check
     *
     * @return string
     */
    public function getMd5check()
    {
        return $this->md5check;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }
}
