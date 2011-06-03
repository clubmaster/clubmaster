<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\OrderStatus")
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
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $status_name
     */
    private $status_name;

    /**
     * @ORM\Column(type="boolean")
     *
     * var boolean $is_accepted
     */
    private $is_accepted;

    /**
     * @ORM\Column(type="boolean")
     *
     * var boolean $is_cancelled
     */
    private $is_cancelled;

    /**
     * @ORM\Column(type="integer")
     *
     * var boolean $priority
     */
    private $priority;


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
     * Set is_accepted
     *
     * @param string $is_accepted
     */
    public function setIsAccepted($isAccepted)
    {
        $this->is_accepted = $isAccepted;
    }

    /**
     * Get is_accepted
     *
     * @return string $is_accepted
     */
    public function getIsAccepted()
    {
        return $this->is_accepted;
    }

    /**
     * Set is_cancelled
     *
     * @param string $is_cancelled
     */
    public function setIsCancelled($isCancelled)
    {
        $this->is_cancelled = $isCancelled;
    }

    /**
     * Get is_cancelled
     *
     * @return string $is_cancelled
     */
    public function getIsCancelled()
    {
        return $this->is_cancelled;
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
