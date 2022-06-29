<?php

namespace App\Entity;

use App\Repository\ContatoDadosRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContatoDadosRepository::class)]
class ContatoDados
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Assert\NotBlank
    * @Assert\Email(
     *     message = "O Email '{{ value }}' não é valido."
     * )
     */
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $telefone;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 10,
     *      max = 100,
     *      minMessage = "O Endereço dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Endereço dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $endereco;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): self
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): self
    {
        $this->endereco = $endereco;

        return $this;
    }
}
