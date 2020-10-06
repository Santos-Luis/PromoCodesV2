<?php

namespace App\DataFixtures;

use App\Entity\PromoCode;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * PromoCodeFixtures.
 */
class PromoCodeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $promoCode = new PromoCode(
            'ABCD1234',
            'test-user',
            '10',
            (new DateTime())->add(new DateInterval('P1M')),
            'uniplaces',
            'Dummy description',
            10.3
        );

        $manager->persist($promoCode);
        $manager->flush();
    }
}
