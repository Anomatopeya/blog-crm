<?php

namespace Aldwyn\BlogCrm\App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * Aldwyn\BlogCrm\App\Models\Article
 *
 * @property int $id
 * @property int $status
 * @property int $category_id
 * @property string $title
 * @property string $slug
 * @property string|null $thumbnail
 * @property array|null $name
 * @property array|null $content
 * @property array|null $short_description
 * @property array $seo_title
 * @property array|null $seo_h1
 * @property array|null $seo_description
 * @property array|null $seo_keywords
 * @property array|null $faq
 * @property array|null $faq_title
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read ArticleCategory $articleCategory
 * @property-read Collection|\App\Models\ArticleCategory[] $categories
 * @property-read int|null $categories_count
 * @property-read ArticleCategory $category
 * @property-read array $translations
 * @property-read ArticleCategory|null $parent
 * @property-read Collection|Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\ArticleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article published()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSeoH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends BaseModel
{
    use HasFactory, CrudTrait, HasTranslations;

    public $translatable = ['name','seo_h1', 'seo_title', 'seo_keywords', 'seo_description', 'short_description', 'content', 'faq', 'faq_title'];

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

    protected $table = 'articles';
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
    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }
    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ArticleCategory::class, 'article_to_category');
    }
    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_to_article');
    }

    /**
     * @return BelongsTo
     */
    public function articleCategory(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }


    /**
     * @return HasOne
     */
    function parent(): HasOne
    {
        return $this->HasOne(ArticleCategory::class, 'id', 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopePublished($query)
    {
        return $query->where('status', true)->orderBy('updated_at', 'DESC');
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
