<?php

namespace App\Updater;

use App\DependencyInjection\DateTimeExtension;
use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;
use DateTime;

/**
 * PromoCodeUpdater.
 */
class PromoCodeUpdater
{
    /**
     * @var PromoCodeRepository
     */
    private $promoCodeRepository;

    public function __construct(PromoCodeRepository $promoCodeRepository)
    {
        $this->promoCodeRepository = $promoCodeRepository;
    }

    public function updateDiscountPercentage(PromoCode $promoCode, int $discountPercentage, string $updatedBy): PromoCode
    {
        $promoCode->setDiscountPercentage($discountPercentage);
        $promoCode = $this->setUpdated($promoCode, $updatedBy);

        $this->promoCodeRepository->save($promoCode);

        return $promoCode;
    }

    public function updateExpirationDate(PromoCode $promoCode, DateTime $expirationDate, string $updatedBy): PromoCode
    {
        $promoCode->setExpirationDate($expirationDate);
        $promoCode = $this->setUpdated($promoCode, $updatedBy);

        if ($expirationDate > DateTimeExtension::getNowDateTime()) {
            $promoCode->setActive(true);
        }

        $this->promoCodeRepository->save($promoCode);

        return $promoCode;
    }

    public function updateDescription(PromoCode $promoCode, string $description, string $updatedBy): PromoCode
    {
        $promoCode->setDescription($description);
        $promoCode = $this->setUpdated($promoCode, $updatedBy);

        $this->promoCodeRepository->save($promoCode);

        return $promoCode;
    }

    public function updateRevenueShare(PromoCode $promoCode, float $revenueShare, string $updatedBy): PromoCode
    {
        $promoCode->setRevenueShare($revenueShare);
        $promoCode = $this->setUpdated($promoCode, $updatedBy);

        $this->promoCodeRepository->save($promoCode);

        return $promoCode;
    }

    private function setUpdated(PromoCode $promoCode, string $updatedBy): PromoCode
    {
        $promoCode->setUpdatedBy($updatedBy);
        $promoCode->setUpdatedAt(DateTimeExtension::getNowDateTime());

        return $promoCode;
    }
}
