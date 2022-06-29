<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
      /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "O nome do Cliente dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O nome do Cliente dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $nome;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagen;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }
}
