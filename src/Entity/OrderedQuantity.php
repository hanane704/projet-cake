<?php

namespace App\Entity;

use App\Repository\OrderedQuantityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderedQuantityRepository::class)
 */
class OrderedQuantity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cake::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $cake;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderedQuantities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fromOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCake(): ?Cake
    {
        return $this->cake;
    }

    public function setCake(?Cake $cake): self
    {
        $this->cake = $cake;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getFromOrder(): ?Order
    {
        return $this->fromOrder;
    }

    public function setFromOrder(?Order $fromOrder): self
    {
        $this->fromOrder = $fromOrder;

        return $this;
    }
}
