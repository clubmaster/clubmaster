<?php

namespace Club\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\EventBundle\Repository\Event")
 * @ORM\Table(name="club_event_event")
 */
class Event
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
     * @Assert\NotBlank()
     *
     * @var string $event_name
     */
    private $event_name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $description
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", scale="2")
     *
     * @var string $price
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     *
     * @var string $max_attends
     */
    private $max_attends;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $start_date
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $stop_date
     */
    private $stop_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $created_at
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $updated_at
     */
    private $updated_at;
}
