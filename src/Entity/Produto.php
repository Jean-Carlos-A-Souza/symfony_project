<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;


use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
#[ORM\Table(name: '`produto`')]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
         /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 25,
     *      max = 70,
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
     *      max = 30,
     *      minMessage = "O Titulo dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Titulo dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $titulo;
    
    #[ORM\Column(type: 'string')]
    private $imagen;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }
}
