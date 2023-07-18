<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $seatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guest $bookedBy = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Table $reservedTable = null;

    #[ORM\Column]
    private ?int $partySize = null;

    #[ORM\Column]
    private ?int $totalAmount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeatedAt(): ?\DateTimeImmutable
    {
        return $this->seatedAt;
    }

    public function setSeatedAt(\DateTimeImmutable $seatedAt): static
    {
        $this->seatedAt = $seatedAt;

        return $this;
    }

    public function getBookedBy(): ?Guest
    {
        return $this->bookedBy;
    }

    public function setBookedBy(?Guest $bookedBy): static
    {
        $this->bookedBy = $bookedBy;

        return $this;
    }

    public function getReservedTable(): ?Table
    {
        return $this->reservedTable;
    }

    public function setReservedTable(?Table $reservedTable): static
    {
        $this->reservedTable = $reservedTable;

        return $this;
    }

    public function getPartySize(): ?int
    {
        return $this->partySize;
    }

    public function setPartySize(int $partySize): static
    {
        $this->partySize = $partySize;

        return $this;
    }

    public function getTotalAmount(): ?int
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(int $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }
}
