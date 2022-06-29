<?php

namespace App\Entity;

use App\Repository\BannerRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BannerRepository::class)]
class Banner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagen;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 5,
     *      max = 25,
     *      minMessage = "O Titulo do banner dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Titulo do banner dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $titulo;

    #[ORM\Column(type: 'string', length: 255)]
      /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 35,
     *      max = 55,
     *      minMessage = "A Descrição do banner dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Descrição do banner dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $descricao;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen( $imagen)
    {
        $this->imagen = $imagen;

        return $this;
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
