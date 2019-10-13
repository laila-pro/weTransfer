<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FichierRepository")
 */
class Fichier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=30)
     */
    private $dest;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $expd;

    /**
     * @ORM\Column(type="string")
     */
    private $nomfile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomdest;

    public function getId(): ?int
    {
        return $this->id;
    }


        public function getDest(): ?string
    {
        return $this->dest;
    }

    public function setDest(string $dest): self
    {
        $this->dest = $dest;

        return $this;
    }

    public function getExpd(): ?string
    {
        return $this->expd;
    }

    public function setExpd(string $expd): self
    {
        $this->expd = $expd;

        return $this;
    }

    public function getNomfile(): ?string
    {
        return $this->nomfile;
    }

    public function setNomfile(string $nomfile): self
    {
        $this->nomfile = $nomfile;

        return $this;
    }

    public function getNomdest(): ?string
    {
        return $this->nomdest;
    }

    public function setNomdest(string $nomdest): self
    {
        $this->nomdest = $nomdest;

        return $this;
    }
}
