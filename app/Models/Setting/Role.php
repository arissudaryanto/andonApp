<?php

namespace App\Models\Setting;

use DateTimeInterface;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole {
  protected $guard_name = 'web';
  public function getRouteKeyName() {
    return 'name';
  }
  protected $hidden = [
    'pivot', 'guard_name', 'id',
  ];
  protected function serializeDate(DateTimeInterface $date): string {
    return $date->format('Y-m-d H:i:s');
  }
}
