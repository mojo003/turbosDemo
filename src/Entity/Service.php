<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_service", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idService;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_de_service", type="string", length=50, nullable=true)
     */
    private $typeDeService;

    public function getIdService(): ?int
    {
        return $this->idService;
    }

    public function getTypeDeService(): ?string
    {
        return $this->typeDeService;
    }

    public function setTypeDeService(?string $typeDeService): self
    {
        $this->typeDeService = $typeDeService;

        return $this;
    }


}
