<?php

namespace App\Library;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Helpers {
  public static function getMenuActiveClass(
    $routeChecker,
    $cssClassName,
    $defaultCssClassName = '',
  ) {
    $routeName = Route::currentRouteName();
    if (strpos($routeChecker, ',') !== false) {
      $routes = explode(',', $routeChecker);
      foreach ($routes as $route) {
        if ($routeName === $route) {
          return $cssClassName;
        }
      }
      return $defaultCssClassName;
    } elseif ($routeName === $routeChecker) {
      return $cssClassName;
    }
    return $defaultCssClassName;
  }

  public function toUpper($string = null) {
    if (!empty($string) && $string !== null) {
      return Str::upper($string);
    }
    return $string;
  }

  public function toLower($string = null) {
    if (!empty($string) && $string !== null) {
      return Str::lower($string);
    }
    return $string;
  }

  public function toTitle($string = null) {
    if (!empty($string) && $string !== null) {
      return Str::title($string);
    }
    return $string;
  }

  public function arrayToObject($array) {
    if (!is_array($array)) {
      return $array;
    }

    $object = new \stdClass();
    foreach ($array as $key => $value) {
      $object->$key = self::arrayToObject($value);
    }

    return $object;
  }

  public function getCommonStatus($status = null) {
    $statuses = [
      [
        'name' => __('auth/common.inactive'),
        'class' => 'badge-danger text-white',
        'value' => 'inactive',
      ],
      [
        'name' => __('auth/common.active'),
        'class' => 'badge-success text-black',
        'value' => 'active',
      ],
    ];

    if ($status !== null) {
      foreach ($statuses as $allStatus) {
        if ($allStatus['value'] === $status) {
          return $allStatus;
        }
      }
    }
    return $statuses;
  }

  public function getPaymentStatus($status = null) {
    $statuses = [
      [
        'name' => __('auth/common.failed'),
        'class' => 'badge-danger text-white',
        'value' => 'failed',
      ],
      [
        'name' => __('auth/common.succeeded'),
        'class' => 'badge-success text-black',
        'value' => 'succeeded',
      ],
    ];

    if ($status !== null) {
      foreach ($statuses as $allStatus) {
        if ($allStatus['value'] === $status) {
          return $allStatus;
        }
      }
    }
    return $statuses;
  }

  public function formatDateTime($dateTime, $format = 'd/m/Y h:i a') {
    if (empty($dateTime)) {
      return $dateTime;
    }
    if ($format === 'UTC ISO') {
      $newDateTime = Carbon::parse(strtotime($dateTime))->setTimezone(
        'Asia/Kuala_Lumpur',
      );
      return $newDateTime->format('Y-m-d');
    }
    $newDateTime = Carbon::parse(strtotime($dateTime))->setTimezone('UTC');
    return $newDateTime->format($format);
  }

  public function getCurrencyFormat($value) {
    if (is_numeric($value)) {
      return number_format($value, 2, '.', '');
    }
    return $value;
  }

  public function isAccessGroupAllowed($permittedAccessGroup) {
    $userAccessGroup = session('user.accessGroup');
    return in_array($userAccessGroup, $permittedAccessGroup);
  }
}
