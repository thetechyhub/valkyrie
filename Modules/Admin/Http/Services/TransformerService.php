<?php

namespace Modules\Core\Http\Services;

abstract class TransformerService {

  public static function transformCollection($items){
    $data = [];

    foreach ($items as $item) {
      $payload = self::transform($item);
      if ($payload) {
        $data[] = $payload;
      }
    }

    return $data;
  }

  public static abstract function transform($item);
}
