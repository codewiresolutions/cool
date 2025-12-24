<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ImgUploader;

class Blog extends Model
{
    protected $table = 'blogs';


    public function printBlogImage($width = 0, $height = 0)
    {
        $logo = (string)$this->image;
        $logo = (!empty($logo)) ? $logo : 'no-no-image.gif';
        return ImgUploader::print_image("uploads/blogs/$logo", $width, $height, '/admin_assets/no-image.png', $this->image);
    }

    public function getCategoriesAttribute()
    {
        if (empty($this->cate_id)) {
            return collect(); // Avoid null errors
        }

        $ids = array_filter(explode(',', $this->cate_id));
        return Blog_category::whereIn('id', $ids)->get();
    }
}