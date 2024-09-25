<?php
namespace App\Models\Admin;

use App\Models\AppModel;

class BlogBlogCategory extends AppModel
{
    protected $table = 'blog_blog_categories';
    protected $primaryKey = 'id';
    public $timestamps = false;
}