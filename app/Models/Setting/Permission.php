<?php

namespace App\Models\Setting;

use DateTimeInterface;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission {
  protected $guard_name = 'web';
  public function getRouteKeyName() {
    return 'name';
  }
  protected $hidden = [
    'created_at', 'updated_at', 'pivot', 'guard_name', 'id',
  ];
  protected function serializeDate(DateTimeInterface $date): string {
    return $date->format('Y-m-d H:i:s');
  }
}