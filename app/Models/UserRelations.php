<?php

namespace App\Models;

trait UserRelations
{
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function clinic()
    {
        return $this->hasOne(Clinic::class);
    }
}

