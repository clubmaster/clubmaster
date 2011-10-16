<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\Vat")
 * @ORM\Table(name="club_shop_vat")
 * @ORM\HasLifecycleCallbacks()
 */
class Vat
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
     * @var string $vat_name
     */
    private $vat_name;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var float $rate
     */
    private $rate;

    /**
     * @ORM\Column(type="datetime")
     *
     * var datetime $created_at
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * var datetime $updated_at
     */
    private $updated_at;


    public function __toString()
    {
      return $this->getVatName();
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
     * Set vat_name
     *
     * @param string $vatName
     */
    public function setVatName($vatName)
    {
        $this->vat_name = $vatName;
    }

    /**
     * Get vat_name
     *
     * @return string $vatName
     */
    public function getVatName()
    {
        return $this->vat_name;
    }

    /**
     * Set rate
     *
     * @param float $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get rate
     *
     * @return float $rate
     */
    public function getRate()
    {
        return $this->rate;
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
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }
}
