<?php

namespace App\Entity;

use App\DependencyInjection\DateTimeExtension;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PromoCodeRepository")
 * @ORM\Table(name="PromoCode")
 */
class PromoCode
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=8)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=254)
     */
    private $owner;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $discountPercentage;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $expirationDate;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=254)
     */
    private $createdBy;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=254)
     */
    private $updatedBy;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $revenueShare;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastUsedAt;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $numberOfUses;

    public function __construct(
        string $id,
        string $owner,
        int $discountPercentage,
        DateTime $expirationDate,
        string $createdBy,
        string $description,
        float $revenueShare = 0
    ) {
        $this->id = $id;
        $this->owner = $owner;
        $this->discountPercentage = $discountPercentage;
        $this->expirationDate = $expirationDate;
        $this->createdBy = $createdBy;
        $this->createdAt = DateTimeExtension::getNowDateTime();
        $this->updatedBy = $this->createdBy;
        $this->updatedAt = $this->createdAt;
        $this->active = true;
        $this->description = $description;
        $this->revenueShare = $revenueShare;
        $this->numberOfUses = 0;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getDiscountPercentage(): int
    {
        return $this->discountPercentage;
    }

    public function getExpirationDate(): DateTime
    {
        return $this->expirationDate;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedBy(): string
    {
        return $this->updatedBy;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getRevenueShare(): float
    {
        return $this->revenueShare;
    }

    public function getLastUsedAt(): ?DateTime
    {
        return $this->lastUsedAt;
    }

    public function getNumberOfUses(): int
    {
        return $this->numberOfUses;
    }

    public function setDiscountPercentage(int $discountPercentage): void
    {
        $this->discountPercentage = $discountPercentage;
    }

    public function setExpirationDate(DateTime $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function setUpdatedBy(string $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setRevenueShare(float $revenueShare): void
    {
        $this->revenueShare = $revenueShare;
    }

    public function setLastUsedAt(?DateTime $lastUsedAt): void
    {
        $this->lastUsedAt = $lastUsedAt;
    }

    public function setNumberOfUses(int $numberOfUses): void
    {
        $this->numberOfUses = $numberOfUses;
    }
}
