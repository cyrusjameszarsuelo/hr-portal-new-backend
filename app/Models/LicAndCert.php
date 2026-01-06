<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LicAndCert extends Model
{
    use SoftDeletes;

    protected $table = 'a_lic_and_certs';

    protected $fillable = [
        'about_id',
        'license_certification_name',
        'issuing_organization',
        'license_certification_number',
        'date_issued',
        'date_of_expiration',
        'non_expiring',
    ];

    protected $casts = [
        'date_issued' => 'date',
        'date_of_expiration' => 'date',
        'non_expiring' => 'boolean',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'about_id');
    }
}
