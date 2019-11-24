<?php

namespace WpComponents\Content\Utilities;

class Validator
{
  /**
     * Validates either post type name or taxonomy name according to their respective naming conventions
     * @param  string $str Validated string
     * @param  string $type Validation rules to apply, either 'post-type' or 'taxonomy'
     * @throws \Exception this is thrown when a validation isn't successful
     * @return void Returns nothing or raises fatal error on illegal string
     */
    public static function validateString(string $str, string $type): void {
      switch ($type) {
      case 'post-type':
          if (strlen($str) > 20) {
              throw new \Exception('Post type name cannot be longer than 20 chars!');
          }
          if (preg_match('([^a-z0-9-_])', $str)) {
              throw new \Exception("Illegal character is used for post type name '$str'! Only alphanum, dash and underscores are allowed!");
          }
          break;
      case 'taxonomy':
          if (strlen($str) > 32) {
              throw new \Exception('Taxonomy name cannot be longer than 32 chars!');
          }
          if (preg_match('([^a-z_])', $str)) {
              throw new \Exception("Illegal character is used for taxonomy name '$str'! Only low case letters and underscores are allowed!");
          }
          break;
      }
  }
}
