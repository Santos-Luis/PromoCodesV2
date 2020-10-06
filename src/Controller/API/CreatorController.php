<?php

namespace App\Controller\API;

use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;
use DateInterval;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * CreatorController.
 */
class CreatorController extends AbstractController
{
    private const DEFAULT_DISCOUNT_PERCENTAGE = 10;
    private const DEFAULT_EXPIRATION_DAYS = 'P1M';
    private const PROMO_CODE_LENGTH = 8;

    /**
     * @Route("/create/{ownerId}", name="create_promo_code_api", methods="POST")
     *
     * @param PromoCodeRepository $promoCodeRepository
     * @param Request             $request
     * @param string              $ownerId
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function create(
        PromoCodeRepository $promoCodeRepository,
        Request $request,
        string $ownerId
    ): JsonResponse {
        $id = $this->generatePromoCodeId();
        $createdBy = $this->getUser();

        $discountPercentage = $request->get('discount-percentage', self::DEFAULT_DISCOUNT_PERCENTAGE);
        $description = $request->get('description', '');
        $revenueShare = $request->get('revenue-share');

        $expirationDate = $request->get('expiration-date');
        $expirationDate = $expirationDate
            ? new DateTime($expirationDate)
            : (new DateTime())->add(new DateInterval(self::DEFAULT_EXPIRATION_DAYS));

        $promoCode = new PromoCode(
            $id,
            $ownerId,
            $discountPercentage,
            $expirationDate,
            $createdBy,
            $description,
            $revenueShare
        );
        $promoCodeRepository->save($promoCode);

        return new JsonResponse(['promo_code_id' => $promoCode->getId()], JsonResponse::HTTP_CREATED);
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    private function generatePromoCodeId(): string
    {
        $random = '';
        for ($i = 0; $i < self::PROMO_CODE_LENGTH; $i++) {
            $random .= random_int(0, 1) ? random_int(0, 9) : chr(random_int(ord('a'), ord('z')));
        }

        return $random;
    }
}
