<?php

namespace App\Entity;

use App\Repository\PedidoItensRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoItensRepository::class)]
class PedidoItens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: produto::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $produto;

    #[ORM\Column(type: 'integer')]
    private $quantidade;

    #[ORM\Column(type: 'float')]
    private $total;

    #[ORM\ManyToOne(targetEntity: Pedido::class, inversedBy: 'pedidoItens')]
    #[ORM\JoinColumn(nullable: false)]
    private $pedido;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduto(): ?produto
    {
        return $this->produto;
    }

    public function setProduto(?produto $produto): self
    {
        $this->produto = $produto;

        return $this;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): self
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(?Pedido $pedido): self
    {
        $this->pedido = $pedido;

        return $this;
    }
}
