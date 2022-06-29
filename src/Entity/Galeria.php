<?php

namespace App\Entity;

use App\Repository\GaleriaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GaleriaRepository::class)]
class Galeria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
        /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 10,
     *      max = 35,
     *      minMessage = "O Titulo dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Titulo dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $titulo;

    #[ORM\Column(type: 'string', length: 255)]
        /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 35,
     *      max = 80,
     *      minMessage = "O Descrição dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Descrição dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $descricao;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }
}
