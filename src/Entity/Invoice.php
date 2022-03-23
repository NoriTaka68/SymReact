<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use ProxyManager\ProxyGenerator\Util\Properties;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(
    normalizationContext: ['groups' => ['read : Invoices', 'read : Customers']],
    itemOperations: ['get', 'put', 'delete', 'patch'],
    paginationClientItemsPerPage:true,
    paginationMaximumItemsPerPage: 30,
    attributes: ["pagination_enabled" => true, "pagination_items_per_page" => 20]

),
ApiFilter(SearchFilter::class, properties:['id' => 'exact', 'status' =>'partial']),
ApiFilter(OrderFilter::class, properties: ['amount', 'setSentAt'])
]
#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read : Invoices'])]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(['read : Invoices'])]
    private $amount;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['read : Invoices'])]
    private $sentAt;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read : Invoices'])]
    private $status;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read : Invoices'])]
    private $customer;

    #[ORM\Column(type: 'integer')]
    private $chrono;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(\DateTimeInterface $sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getChrono(): ?int
    {
        return $this->chrono;
    }

    public function setChrono(int $chrono): self
    {
        $this->chrono = $chrono;

        return $this;
    }
}
