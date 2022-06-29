<?php

namespace App\Entity;

use App\Repository\NoticiaRepository;
use Doctrine\ORM\Mapping as ORM;


use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NoticiaRepository::class)]
class Noticia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 250)]
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
     *      min = 20,
     *      max = 65,
     *      minMessage = "A Descrição dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "A Descrição dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $descricao;

    #[ORM\Column(type: 'string', length: 255)]
         /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 10,
     *      max = 35,
     *      minMessage = "O Autor dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Autor dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $autor;

    #[ORM\Column(type: 'date')]
    private $data;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagen;

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

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

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
