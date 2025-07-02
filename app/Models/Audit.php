<?php

// my Audit model that extends OwenIt\Auditing\Models\Audit , so can customize it as wish

namespace App\Models;

use OwenIt\Auditing\Models\Audit as AuditExtended;

class Audit extends AuditExtended
{
    // Add your custom logic or properties here

    //already defined in parent model
    /*
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    */
}

