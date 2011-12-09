<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\TransactionStatusRepository")
 * @ORM\Table(name="club_shop_transaction_status")
 */
class TransactionStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $status_name
     */
    protected $status_name;


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status_name
     *
     * @param string $statusName
     */
    public function setStatusName($statusName)
    {
        $this->status_name = $statusName;
    }

    /**
     * Get status_name
     *
     * @return string $statusName
     */
    public function getStatusName()
    {
        return $this->status_name;
    }
}
