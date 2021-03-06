<?php

namespace Domain\Security\Authentication\Provider;

use Psr\Cache\CacheItemPoolInterface;
use Domain\Security\Authentication\Token\WssUserToken;
use Domain\Security\Authentication\Token\WsseUserToken;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;

class WsseProvider implements AuthenticationProviderInterface
{
  private $userProvider;
  private $cachePool;

  public function __construct(UserProviderInterface $userProvider, CacheItemPoolInterface $cachePool)
  {
    $this->userProvider = $userProvider;
    $this->cachePool = $cachePool;
  }

  public function authenticate(TokenInterface $token)
  {
    $user = $this->userProvider->loadUserByUsername($token->getUsername());

    if ($user && $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getPassword())) {
      $authenticatedToken = new WsseUserToken($user->getRoles());
      $authenticatedToken->setUser($user);

      return $authenticatedToken;
    }

    throw new AuthenticationException('The WSSE authentication failed.');
  }

  protected function validateDigest($digest, $nonce, $created, $secret)
  {
    // Check created time is not in the future
    if (strtotime($created) > time()) {
      return false;
    }

    // Expire timestamp after 5 minutes
    if (time() - strtotime($created) > 300) {
      return false;
    }

    // Try to fetch the cache item from pool
    $cacheItem = $this->cachePool->getItem(md5($nonce));

    if ($cacheItem->isHit()) {
      throw new AuthenticationException('Previously used nonce detected');
    }

    $cacheItem->set(null)->expiresAfter(300);
    $this->cachePool->save($cacheItem);

    $expected = base64_encode(sha1(base64_decode($nonce) . $created . $secret, true));

    return hash_equals($expected, $digest);
  }

  public function supports(TokenInterface $token)
  {
    return $token instanceof WsseUserToken;
  }
}