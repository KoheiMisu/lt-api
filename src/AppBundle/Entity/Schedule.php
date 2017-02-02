<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Schedule
 *
 * @ORM\Table(name="schedule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScheduleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Schedule
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
     * @var int
     *
     * 0: cancel
     * 1: ready
     * 2: postpone
     *
     * @ORM\Column(name="status", type="integer", options={"default": 1})
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="publish_date", type="datetime")
     */
    private $publishDate;

    /**
     * @var Presenter
     *
     * @ORM\ManyToOne(targetEntity="Presenter", inversedBy="schedules")
     * @ORM\JoinColumn(name="presenter_id", referencedColumnName="id", nullable=false)
     */
    private $presenter;


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
     * Set status
     *
     * @param integer $status
     *
     * @return Schedule
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set publishDate
     *
     * @param \DateTime $publishDate
     *
     * @return Schedule
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * Get publishDate
     *
     * @return \DateTime
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set presenter
     *
     * @param \AppBundle\Entity\Presenter $presenter
     *
     * @return Schedule
     */
    public function setPresenter(\AppBundle\Entity\Presenter $presenter)
    {
        $this->presenter = $presenter;

        return $this;
    }

    /**
     * Get presenter
     *
     * @return \AppBundle\Entity\Presenter
     */
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * set values before persist
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->status = 1;
    }
}
