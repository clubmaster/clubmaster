<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\OrderStatusRepository")
 * @ORM\Table(name="club_shop_order_status")
 */
class OrderStatus
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
     * @ORM\Column(type="boolean")
     *
     * var boolean $accepted
     */
    protected $accepted;

    /**
     * @ORM\Column(type="boolean")
     *
     * var boolean $cancelled
     */
    protected $cancelled;

    /**
     * @ORM\Column(type="integer")
     *
     * var boolean $priority
     */
    protected $priority;


    public function __toString()
    {
      return $this->getStatusName();
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

    /**
     * Set status_name
     *
     * @param string $status_name
     */
    public function setStatusName($statusName)
    {
        $this->status_name = $statusName;
    }

    /**
     * Get status_name
     *
     * @return string $status_name
     */
    public function getStatusName()
    {
        return $this->status_name;
    }

    /**
     * Set accepted
     *
     * @param string $accepted
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
    }

    /**
     * Get accepted
     *
     * @return string $accepted
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set cancelled
     *
     * @param string $cancelled
     */
    public function setCancelled($cancelled)
    {
        $this->cancelled = $cancelled;
    }

    /**
     * Get cancelled
     *
     * @return string $cancelled
     */
    public function getCancelled()
    {
        return $this->cancelled;
    }

    /**
     * Set priority
     *
     * @param string $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * Get priority
     *
     * @return string $priority
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
