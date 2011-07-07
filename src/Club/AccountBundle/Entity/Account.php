<?php

namespace Club\AccountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\AccountBundle\Repository\Account")
 * @ORM\Table(name="club_account_account")
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     *
     * @var string $account_name
     */
    private $account_name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string $account_number
     */
    private $account_number;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice({ "asset", "liability", "equity", "income", "expense" })
     *
     * @var string $account_type
     */
    private $account_type;


    public function __toString()
    {
      return $this->getAccountNumber(). ' ('.$this->getAccountName().')';
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    public function setAccountName($account_name)
    {
        $this->account_name = $account_name;
    }

    public function getAccountName()
    {
        return $this->account_name;
    }

    public function setAccountNumber($account_number)
    {
        $this->account_number = $account_number;
    }

    public function getAccountNumber()
    {
        return $this->account_number;
    }

    public function setAccountType($account_type)
    {
        $this->account_type = $account_type;
    }

    public function getAccountType()
    {
        return $this->account_type;
    }
}
