<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavouriteCompany extends Model
{

    public $timestamps = true;
    protected $table = 'favourites_company';
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_slug', 'slug');
    }
}
