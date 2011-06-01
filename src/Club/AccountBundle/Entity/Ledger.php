<?php

namespace Club\AccountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\AccountBundle\Repository\Ledger")
 * @ORM\Table(name="club_account_ledger")
 */
class Ledger
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
     * @ORM\Column(type="decimal", scale="2")
     *
     * @var string $value
     */
    private $value;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $note
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $created_at
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Account")
     */
    private $account;


    public function __construct()
    {
      if (!$this->getId())
        $this->setCreatedAt(new \DateTime());
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

    public function setValue($value)
    {
      $this->value = $value;
    }

    public function getValue()
    {
      return $this->value;
    }

    public function setNote($note)
    {
      $this->note = $note;
    }

    public function getNote()
    {
      return $this->note;
    }

    public function setCreatedAt(\DateTime $created_at)
    {
      $this->created_at = $created_at;
    }

    public function getCreatedAt()
    {
      return $this->created_at;
    }

    public function setAccount(\Club\AccountBundle\Entity\Account $account)
    {
      $this->account = $account;
    }

    public function getAccount()
    {
      return $this->account;
    }
}
