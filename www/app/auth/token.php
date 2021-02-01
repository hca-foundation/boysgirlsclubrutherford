<?php

use Firebase\JWT\JWT;

/**
 * Class containing static members for managing jwt access token
 */
class AccessToken {
  private static $encryption = 'HS256';
  private static $key = 'CAFEA69292B91A4B323C57F8E9237';
  private static $timeout = 7200; // 2 hours
  public static $cookieName = 'BGCRC_Access_Token';

  /**
   * Returns auth token cookie if set, otherwise null
   */
  private static function getTokenIfSet() {
    return isset($_COOKIE[self::$cookieName]) ? $_COOKIE[self::$cookieName] : null;
  }

  /**
   * Sets access token cookie, with user payload
   */
  public static function set(array $userPayload): void {
    $jwt = JWT::encode($userPayload, self::$key, self::$encryption);
    setcookie(self::$cookieName, $jwt, time() + self::$timeout, '/');
  }

  /**
   * Decodes jwt and returns original associative array, returns
   * null if not set
   * @return array|null
   */
  public static function get() {
    $jwt = self::getTokenIfSet();

    if (empty($jwt)) return null;

    return (array) JWT::decode($jwt, self::$key, [self::$encryption]);
  }

  /**
   * Clears out access token, logging the user out
   */
  public static function clear(): void {
    $jwt = self::getTokenIfSet();

    if ($jwt) {
      setcookie(self::$cookieName, '', time() - 3600, '/'); // deletes cookie
    }
  }
}
