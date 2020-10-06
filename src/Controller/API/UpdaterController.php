<?php

namespace App\Controller\API;

use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;
use App\Updater\PromoCodeUpdater;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * UpdaterController.
 */
class UpdaterController extends AbstractController
{
    /**
     * @var PromoCodeRepository
     */
    private $promoCodeRepository;

    /**
     * @var PromoCodeUpdater
     */
    private $promoCodeUpdater;

    public function __construct(PromoCodeRepository $promoCodeRepository, PromoCodeUpdater $promoCodeUpdater)
    {
        $this->promoCodeRepository = $promoCodeRepository;
        $this->promoCodeUpdater = $promoCodeUpdater;
    }

    /**
     * @Route("/update/{promoCodeId}", name="update_promo_code_api", methods="PATCH")
     *
     * @param string  $promoCodeId
     * @param Request $request
     *
     * @return Response
     *
     * @throws Exception
     */
    public function updatePromoCode(string $promoCodeId, Request $request): Response
    {
        $promoCode = $this->promoCodeRepository->find($promoCodeId);
        if (!$promoCode instanceof PromoCode) {
            return new Response('Error: invalid promo code', Response::HTTP_NOT_FOUND);
        }

        $updatedBy = $this->getUser()->getUsername();
        $updatedFields = [];

        $newDiscountPercentage = $request->get('discount-percentage');
        if ($newDiscountPercentage) {
            $this->promoCodeUpdater->updateDiscountPercentage($promoCode, $newDiscountPercentage, $updatedBy);
            $updatedFields[] = 'discount percentage';
        }

        $newExpirationDate = $request->get('expiration-date');
        if ($newExpirationDate) {
            $this->promoCodeUpdater->updateExpirationDate($promoCode, new DateTime($newExpirationDate), $updatedBy);
            $updatedFields[] = 'expiration date';
        }

        $newDescription = $request->get('description');
        if ($newDescription) {
            $this->promoCodeUpdater->updateDescription($promoCode, $newDescription, $updatedBy);
            $updatedFields[] = 'description';
        }

        $newRevenueShare = $request->get('revenue-share');
        if ($newRevenueShare) {
            $this->promoCodeUpdater->updateRevenueShare($promoCode, $newRevenueShare, $updatedBy);
            $updatedFields[] = 'revenue share';
        }

        if (empty($updatedFields)) {
            return new Response('No fields updated', Response::HTTP_NO_CONTENT);
        }

        $updatedMessage = 'Successfully updated the ';
        foreach ($updatedFields as $updatedField) {
            $updatedMessage .= $updatedField . ', ';
        }
        $updatedMessage = substr($updatedMessage, 0, -2);

        return new Response($updatedMessage, Response::HTTP_OK);
    }
}
