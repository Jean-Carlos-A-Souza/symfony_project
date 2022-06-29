<?php

namespace App\Entity;

use App\Repository\DepoimentoRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DepoimentoRepository::class)]
class Depoimento
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
     *      max = 35,
     *      minMessage = "O Nome dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Nome dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $nome;

    #[ORM\Column(type: 'string', length: 255)]
         /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 45,
     *      max = 120,
     *      minMessage = "O Depoimento dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Depoimento dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $depoimento;

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

    public function getDepoimento(): ?string
    {
        return $this->depoimento;
    }

    public function setDepoimento(string $depoimento): self
    {
        $this->depoimento = $depoimento;

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
