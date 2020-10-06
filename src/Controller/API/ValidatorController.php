<?php

namespace App\Controller\API;

use App\DependencyInjection\DateTimeExtension;
use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ValidatorController.
 */
class ValidatorController
{
    /**
     * @Route("/validate/{promoCodeId}/{userId}", name="validate_promo_code_api", methods="GET")
     *
     * @param string              $promoCodeId
     * @param string              $userId
     * @param PromoCodeRepository $promoCodeRepository
     *
     * @return Response
     *
     * @throws Exception
     */
    public function validatePromoCode(
        string $promoCodeId,
        string $userId,
        PromoCodeRepository $promoCodeRepository
    ): Response {
        $promoCode = $promoCodeRepository->find($promoCodeId);
        if (!$promoCode instanceof PromoCode) {
            return new Response('Error: invalid promo code id', Response::HTTP_NOT_FOUND);
        }

        if ($promoCode->getOwner() === $userId) {
            return new Response('Error: user cannot use own promo code', Response::HTTP_UNAUTHORIZED);
        }

        if (!$promoCode->getActive()) {
            return new Response('Error: promo code already expired', Response::HTTP_NOT_ACCEPTABLE);
        }

        if ($promoCode->getExpirationDate() < DateTimeExtension::getNowDateTime()) {
            $promoCode->setActive(false);
            $promoCodeRepository->save($promoCode);

            return new Response('Error: promo code already expired', Response::HTTP_NOT_ACCEPTABLE);
        }

        $promoCode->setLastUsedAt(DateTimeExtension::getNowDateTime());
        $promoCode->setNumberOfUses($promoCode->getNumberOfUses() + 1);
        $promoCodeRepository->save($promoCode);

        return new Response('Valid promo code', Response::HTTP_OK);
    }
}
