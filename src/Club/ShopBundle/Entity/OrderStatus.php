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
     * var boolean $is_complete
     */
    private $is_complete;

    /**
     * @ORM\Column(type="integer")
     *
     * var boolean $priority
     */
    private $priority;


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
     * Set is_complete
     *
     * @param string $is_complete
     */
    public function setIsComplete($isComplete)
    {
        $this->is_complete = $isComplete;
    }

    /**
     * Get is_complete
     *
     * @return string $is_complete
     */
    public function getIsComplete()
    {
        return $this->is_complete;
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
