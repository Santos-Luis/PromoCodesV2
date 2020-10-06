<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUser;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * JwtAuthenticator
 */
class JwtAuthenticator extends AbstractGuardAuthenticator
{
    private const AUTHORIZATION_HEADER_KEY = 'Authorization';
    private const AUTHORIZATION_TOKEN_PREFIX = 'Bearer';

    /**
     * @var JWTEncoderInterface
     */
    private $jwtEncoder;

    /**
     * @var TokenExtractorInterface
     */
    private $tokenExtractor;

    /**
     * @param JWTEncoderInterface $jwtEncoder
     */
    public function __construct(JWTEncoderInterface $jwtEncoder)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->tokenExtractor = $this->getTokenExtractor();
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request): bool
    {
        return false !== $this->tokenExtractor->extract($request);
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request): ?string
    {
        $token = $this->tokenExtractor->extract($request);

        return $token !== false ? $token : null;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): JWTUser
    {
        $data = $this->jwtEncoder->decode($credentials);

        return User::createFromPayload($data['username'], $data);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        // This validation is done by decoding the token
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null): JsonResponse
    {
        return new JsonResponse('Authentication header required', Response::HTTP_UNAUTHORIZED);
    }

    private function getTokenExtractor(): AuthorizationHeaderTokenExtractor
    {
        return new AuthorizationHeaderTokenExtractor(
            self::AUTHORIZATION_TOKEN_PREFIX,
            self::AUTHORIZATION_HEADER_KEY
        );
    }
}
