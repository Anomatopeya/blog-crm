<?php

namespace Aldwyn\BlogCrm\App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * App\Models\ArticleCategory
 *
 * @property int $id
 * @property int $status
 * @property int|null $parent_id
 * @property int $order
 * @property string $title
 * @property string $slug
 * @property string|null $thumbnail
 * @property array|null $content
 * @property array|null $short_description
 * @property array $seo_title
 * @property array|null $seo_h1
 * @property array|null $seo_description
 * @property array|null $seo_keywords
 * @property int $rgt
 * @property int $lft
 * @property int $depth
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ArticleCategory[] $children
 * @property-read int|null $children_count
 * @property-read array $translations
 * @property-read ArticleCategory|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\ArticleCategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory published()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereSeoH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleCategory extends BaseModel
{
    use HasFactory, CrudTrait, HasTranslations;

    public $translatable = ['name','seo_h1', 'seo_title', 'seo_keywords', 'seo_description', 'short_description', 'content'];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($question) {
            $question->slug = $question->slug ?? Str::slug($question->title);
        });
        static::saving(function ($question) {
            $question->slug = $question->slug ?? Str::slug($question->title);
        });
    }
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'article_categories';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * @return BelongsTo
     */
    function parent(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order')->with('children');
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_to_article_category');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopePublished($query)
    {
        return $query->where('status', true)->orderBy('lft', 'ASC');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
