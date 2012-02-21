<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;


/**
 * Club\TeamBundle\Entity\TeamUser
 *
 * @ORM\Table(name="club_team_team_user",
 *    uniqueConstraints={@ORM\UniqueConstraint(name="unique_idx", columns={"user_id","team_id"})}
 * )
 * @ORM\Entity(repositoryClass="Club\TeamBundle\Entity\TeamUserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Assert\Callback(groups={"attend"}, methods={"isFull","isExpired"})
 */
class TeamUser
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Club\TeamBundle\Entity\Team")
     */
    protected $team;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;


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
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     */
    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Club\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }

    /**
     * Set team
     *
     * @param Club\TeamBundle\Entity\Team $team
     */
    public function setTeam(\Club\TeamBundle\Entity\Team $team)
    {
        $this->team = $team;
    }

    /**
     * Get team
     *
     * @return Club\TeamBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    public function isFull(ExecutionContext $context)
    {
      if (count($this->getTeam()->getUsers()) >= $this->getTeam()->getMaxAttend()) {
        $property_path = $context->getPropertyPath() . '.users';
        $context->setPropertyPath($property_path);
        $context->addViolation('The team is already full!', array(), null);
      }
    }

    public function isExpired(ExecutionContext $context)
    {
      if ($this->getTeam()->getFirstDate()->getTimestamp() < time()) {
        $property_path = $context->getPropertyPath() . '.users';
        $context->setPropertyPath($property_path);
        $context->addViolation('The team is already started!', array(), null);
      }
    }
}
