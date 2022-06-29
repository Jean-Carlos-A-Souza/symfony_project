<?php

namespace App\Entity;

use App\Repository\ContatoRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContatoRepository::class)]
class Contato
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
     *      max = 40,
     *      minMessage = "O Nome dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Nome dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $nome;
   
    #[ORM\Column(type: 'string', length: 255)]
         /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "O Sobrenome dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Sobrenome dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $sobrenome;

    #[ORM\Column(type: 'string')]
         /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 13,
     *      max = 15,
     *      minMessage = "O Telefone dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "O Telefone dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $telefone;

    #[ORM\Column(type: 'string', length: 255)]
         /**
     * @Assert\NotBlank
    * @Assert\Email(
     *     message = "O Email '{{ value }}' não é valido."
     * )
     */
    private $email;

    #[ORM\Column(type: 'date')]
    private $data;
    
    #[ORM\Column(type: 'string', length: 255)]
         /**
     * @Assert\NotBlank
     *  * @Assert\Length(
     *      min = 35,
     *      max = 150,
     *      minMessage = "A Mensagem dever ter mais de {{ limit }} caracteres",
     *      maxMessage = "A Mensagem dever ter menos de {{ limit }} caracteres"
     * )
     */
    private $mensagem;

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

    public function getSobrenome(): ?string
    {
        return $this->sobrenome;
    }

    public function setSobrenome(string $sobrenome): self
    {
        $this->sobrenome = $sobrenome;

        return $this;
    }



    public function getTelefone():  ?string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): self
    {
        $this->telefone = $telefone;

        return $this;
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

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getMensagem(): ?string
    {
        return $this->mensagem;
    }

    public function setMensagem(string $mensagem): self
    {
        $this->mensagem = $mensagem;

        return $this;
    }
}
