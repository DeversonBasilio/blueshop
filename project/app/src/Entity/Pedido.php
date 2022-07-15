<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $datacriado;

    #[ORM\Column(type: 'string', length: 24)]
    private $Status;

    #[ORM\Column(type: 'float')]
    private $total;

    #[ORM\ManyToOne(targetEntity: usuario::class, inversedBy: 'pedidos')]
    #[ORM\JoinColumn(nullable: false)]
    private $usuario;

    #[ORM\OneToMany(mappedBy: 'pedido', targetEntity: pedidoItens::class, orphanRemoval: true, cascade: ["persist", "remove"])]
    private $pedidoItens;

    public function __construct()
    {
        $this->pedidoItens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataCriado(): ?\DateTimeInterface
    {
        return $this->datacriado;
    }

    public function setDataCriado(\DateTimeInterface $datacriado): self
    {
        $this->datacriado = $datacriado;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

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

    public function getUsuario(): ?usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return Collection<int, pedidoItens>
     */
    public function getPedidoItens(): Collection
    {
        return $this->pedidoItens;
    }

    public function addPedidoIten(pedidoItens $pedidoIten): self
    {
        if (!$this->pedidoItens->contains($pedidoIten)) {
            $this->pedidoItens[] = $pedidoIten;
            $pedidoIten->setPedido($this);
        }

        return $this;
    }

    public function removePedidoIten(pedidoItens $pedidoIten): self
    {
        if ($this->pedidoItens->removeElement($pedidoIten)) {
            
            if ($pedidoIten->getPedido() === $this) {
                $pedidoIten->setPedido(null);
            }
        }

        return $this;
    }

    public function calculaTotalItens() : void
    {
        $this->total = 0;
        foreach ($this->pedidoItens as $pedidoIten) {
                $this->total += $pedidoIten->getTotal();
        }
    }

    public function contaItens() : int
    {
        $quantidade_itens = 0;

        foreach ($this->pedidoItens as $pedidoIten) {
                $quantidade_itens += 1;
        }

        return $quantidade_itens;
    }
}
