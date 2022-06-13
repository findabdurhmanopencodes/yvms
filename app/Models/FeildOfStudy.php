<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FeildOfStudy extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

        /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
      'name'
  ];
  public function applicant()
  {
      return $this->hasMany(Volunter::class);
  }
}



