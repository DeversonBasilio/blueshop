<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nome;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $descricao;

    #[ORM\Column(type: 'float', nullable: true)]
    private $preco;

    #[ORM\ManyToMany(targetEntity: categoria::class, inversedBy: 'categorias')]
    private $categorias;

    #[ORM\OneToOne(targetEntity: image::class, cascade: ['persist', 'remove'])]
    private $foto;
    
    public function __construct()
    {
        $this->categorias = new ArrayCollection();
    }

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

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getPreco(): ?float
    {
        return $this->preco;
    }

    public function setPreco(?float $preco): self
    {
        $this->preco = $preco;

        return $this;
    }

    /**
     * @return Collection<int, categoria>
     */
    public function getCategorias(): Collection
    {
        return $this->categorias;
    }

    public function addCategoria(categoria $categoria): self
    {
        if (!$this->categorias->contains($categoria)) {
            $this->categorias[] = $categoria;
        }

        return $this;
    }

    public function removeCategoria(categoria $categoria): self
    {
        $this->categorias->removeElement($categoria);

        return $this;
    }

    public function getFoto(): ?image
    {
        return $this->foto;
    }

    public function setFoto(?image $foto): self
    {
        $this->foto = $foto;

        return $this;
    }   

    public function __toString() {
        return $this->nome;
    }
}
