<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\OrderStatusHistoryRepository")
 * @ORM\Table(name="club_shop_order_status_history")
 * @ORM\HasLifecycleCallbacks()
 */
class OrderStatusHistory
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
     * @ORM\Column(type="string", nullable="true")
     * @var text $note
     */
    protected $note;

    /**
     * @ORM\ManyToOne(targetEntity="OrderStatus")
     *
     * @var Club\ShopBundle\Entity\OrderStatus
     */
    protected $order_status;

    /**
     * @ORM\ManyToOne(targetEntity="Order")
     * @ORM\JoinColumn(name="order_id", onDelete="cascade")
     *
     * @var Club\ShopBundle\Entity\Order
     */
    protected $order;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;


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
     * Set note
     *
     * @param text $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Get note
     *
     * @return text $note
     */
    public function getNote()
    {
        return $this->note;
    }

    public function setOrder($order)
    {
      $this->order = $order;
    }

    public function getOrder()
    {
      return $this->order;
    }

    /**
     * Set order_status
     *
     * @param Club\ShopBundle\Entity\OrderStatus $shopOrderStatus
     */
    public function setOrderStatus(\Club\ShopBundle\Entity\OrderStatus $shopOrderStatus)
    {
        $this->order_status = $shopOrderStatus;
    }

    /**
     * Get order_status
     *
     * @return Club\ShopBundle\Entity\OrderStatus $shopOrderStatus
     */
    public function getOrderStatus()
    {
        return $this->order_status;
    }

    public function setCreatedAt($created_at)
    {
      $this->created_at = $created_at;
    }

    public function getCreatedAt()
    {
      return $this->created_at;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }
}