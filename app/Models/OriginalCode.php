<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OriginalCode
 * @package App\Models
 *
 * @property int $id
 * @property int $article_id
 * @property string $value
 * @property string $value_search
 */
class OriginalCode extends Model
{
    public $timestamps = false;
    protected $fillable = ['article_id', 'value', 'value_search'];
}
