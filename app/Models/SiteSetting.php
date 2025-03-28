<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'name',
        'title',
        'meta_description',
        'site_preview_image',
        'favicon',
        'logo',
        'email',
        'phone',
        'address',
        'short_description',
        'site_link',
        'facebook_link',
        'twitter_link',
        'linkedin_link',
        'instagram_link',
        'youtube_link',
    ];

    public function company()
    {
        return $this->belongsTo(User::class);
    }
}
