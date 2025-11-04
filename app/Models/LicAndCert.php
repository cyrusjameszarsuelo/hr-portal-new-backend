<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LicAndCert extends Model
{
    use SoftDeletes;

    protected $table = 'a_lic_and_certs';

    protected $fillable = [
        'a_educ_prof_background_id',
        'lic_and_cert',
    ];

    public function educProfBackground()
    {
        return $this->belongsTo(EducProfBackground::class, 'a_educ_prof_background_id');
    }
}
