<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CompanyContactInfo extends Model
{
    protected $fillable = ['company_id', 'contact_name', 'contact_phone_number', 'contact_phone_ext', 'contact_email', 'contact_alt', 'created_at', 'updated_at'] ;
    
    protected $table = 'company_contact_info';
}
