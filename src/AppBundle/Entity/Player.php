<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use AppBundle\Entity\Team as Team;
use AppBundle\Entity\Perk as Perk;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="player")
 * @UniqueEntity("name")
 */
class Player
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", scale=4)
     */
    protected $born;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $transfermarkt;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="players")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    protected $team;

    /**
     * @ORM\ManyToMany(targetEntity="Perk")
     * @ORM\JoinTable(name="players_perks",
     *      joinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="perk_id", referencedColumnName="id")}
     *      )
     */
    protected $perks;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $classic;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    public function __construct()
    {
        $this->perks = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Player
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
     * Set born
     *
     * @param integer $born
     * @return Player
     */
    public function setBorn($born)
    {
        $this->born = $born;

        return $this;
    }

    /**
     * Get born
     *
     * @return integer
     */
    public function getBorn()
    {
        return $this->born;
    }

    /**
     * Set transfermarkt
     *
     * @param string $transfermarkt
     * @return Player
     */
    public function setTransfermarkt($transfermarkt)
    {
        $this->transfermarkt = $transfermarkt;

        return $this;
    }

    /**
     * Get transfermarkt
     *
     * @return string
     */
    public function getTransfermarkt()
    {
        return $this->transfermarkt;
    }

    /**
     * Set team
     *
     * @param Team $team
     * @return Player
     */
    public function setTeam(Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set classic
     *
     * @param boolean $classic
     * @return Player
     */
    public function setClassic($classic)
    {
        $this->classic = $classic;

        return $this;
    }

    /**
     * Get classic
     *
     * @return boolean
     */
    public function getClassic()
    {
        return $this->classic;
    }

    /**
     * Set enabled
     *
     * @param bool $enabled
     * @return Player
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Add perk
     *
     * @param Perk $perk
     * @return Player
     */
    public function addPerk(Perk $perk)
    {
        $this->perks[] = $perk;

        return $this;
    }

    /**
     * Remove perk
     *
     * @param Perk $perk
     */
    public function removePerk(Perk $perk)
    {
        $this->perks->removeElement($perk);
    }

    /**
     * Get perks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerks()
    {
        return $this->perks;
    }
}
