<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
   protected $fillable = ['user_id', 'company_name', 'company_website', 'company_address', 'company_city', 'company_state', 'company_zip', 
   'company_logo', 'company_status', 'created_at', 'updated_at'] ;
   
   protected $table = 'company_information';

}
