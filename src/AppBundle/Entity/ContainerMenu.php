<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContainerMenu
 *
 * @ORM\Table(name="container_menu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContainerMenuRepository")
 */
class ContainerMenu
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
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="IconAwesome", type="string", length=255)
     */
    private $iconAwesome;

    /**
     * @var string
     *
     * @ORM\Column(name="Path", type="string", length=255)
     */
    private $path;


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
     * @return ContainerMenu
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
     * Set iconAwesome
     *
     * @param string $iconAwesome
     *
     * @return ContainerMenu
     */
    public function setIconAwesome($iconAwesome)
    {
        $this->iconAwesome = $iconAwesome;

        return $this;
    }

    /**
     * Get iconAwesome
     *
     * @return string
     */
    public function getIconAwesome()
    {
        return $this->iconAwesome;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return ContainerMenu
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}

