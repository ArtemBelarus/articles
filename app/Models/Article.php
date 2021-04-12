<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Article
 * @package App\Models
 *
 * @property int $id
 * @property string $number
 * @property string $number_search
 *
 * @property-read OriginalCode[] $original_codes
 * @property-read RelatedNumber[] $related_numbers
 * @property-read Ean[] $eans
 */
class Article extends Model
{
    public $timestamps = false;
    protected $fillable = ['number', 'number_search'];

    /**
     * @return HasMany
     */
    public function original_codes(): HasMany
    {
        return $this->hasMany(OriginalCode::class);
    }

    /**
     * @return HasMany
     */
    public function related_numbers(): HasMany
    {
        return $this->hasMany(RelatedNumber::class);
    }

    /**
     * @return HasMany
     */
    public function eans(): HasMany
    {
        return $this->hasMany(Ean::class);
    }
}
