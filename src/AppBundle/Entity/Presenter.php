<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Presenter
 *
 * @ORM\Table(name="presenter")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PresenterRepository")
 * @UniqueEntity(fields="name", message="Sorry, this name is already in use.")
 * @ORM\HasLifecycleCallbacks()
 */
class Presenter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_publish_date", type="datetime")
     */
    private $lastPublishDate;

    /**
     * @var Schedule[]
     *
     * @ORM\OneToMany(targetEntity="Schedule", mappedBy="presenter", cascade={"all"})
     */
    private $schedules;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Presenter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastPublishDate
     *
     * @param \DateTime $lastPublishDate
     *
     * @return Presenter
     */
    public function setLastPublishDate($lastPublishDate)
    {
        $this->lastPublishDate = $lastPublishDate;

        return $this;
    }

    /**
     * Get lastPublishDate
     *
     * @return \DateTime
     */
    public function getLastPublishDate()
    {
        return $this->lastPublishDate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schedules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add schedule
     *
     * @param \AppBundle\Entity\Schedule $schedule
     *
     * @return Presenter
     */
    public function addSchedule(\AppBundle\Entity\Schedule $schedule)
    {
        $this->schedules[] = $schedule;

        return $this;
    }

    /**
     * Remove schedule
     *
     * @param \AppBundle\Entity\Schedule $schedule
     */
    public function removeSchedule(\AppBundle\Entity\Schedule $schedule)
    {
        $this->schedules->removeElement($schedule);
    }

    /**
     * Get schedules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    /**
     * set values before persist
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->lastPublishDate = new \DateTime();
    }
}
