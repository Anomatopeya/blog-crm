<?php

namespace Aldwyn\BlogCrm\App\Http\Controllers\Admin;

use Aldwyn\BlogCrm\App\Http\Requests\ArticleRequest;
use Aldwyn\BlogCrm\App\Models\ArticleCategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ArticleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Article::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/article');
        CRUD::setEntityNameStrings(_t('article'), _t('articles'));
        $this->crud->set('show.setFromDb', false);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'title',
            'label'=> _t('Title'),
            'type' =>'text'
        ]);
        $this->crud->addColumn([
            'name'  => 'status',
            'label' => 'Status',
            'type'  => 'boolean',
            // optionally override the Yes/No texts
            'options' => [
                1 => '<i class="lar la-check-circle" style="color: green"></i>',
                0 => '<i class="las la-times-circle" style="color: red"></i>'
            ]
        ]);
        $this->crud->addColumn([
            'name'  =>  'thumbnail',
            'label' =>  'thumbnail',
            'type'  =>  'image',
            'prefix' => config('app.upload_patch'),
            'width' =>  '100px',
            'height'    =>  'auto'

        ]);
        $this->crud->addColumn([
            'name'  => 'category_id',
            'label' => _t('Category'),
            'type'  => 'relationship',
            'entity'        => 'category', // the method that defines the relationship in your Model
            'attribute'     => 'title', // foreign key attribute that is shown to user
            'model'         => ArticleCategory::class,
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ArticleRequest::class);
        //Tab Main Info
        $this->crud->addFields([
            [
                'name'  => 'status',
                'label' => _t('Publish status'),
                'type'  => 'checkbox',
                'tab'           => _t('Main info'),
            ],
            [
                'name'      =>  'title',
                'title'     =>  _t('Title'),
                'type'      =>  'text',
                'hint'      =>  _t('For admin panel & slug generator'),
                'tab'           => _t('Main info'),
            ],
            [
                'name'      =>  'slug',
                'title'     =>  _t('Slug'),
                'type'      =>  'text',
                'hint'      =>  _t('auto generate'),
                'tab'           => _t('Main info'),
            ],
            [
                'name'      =>  'category_id',
                'title'     =>  _t('Category'),
                'type'      =>  'select2_nested',
                'tab'           => _t('Main info'),
            ],
            [
                'name' => 'thumbnail',
                'label' => _t('Preview'),
                'type' => 'browse',
                'mime_types' => ['image'],
                'tab'           => _t('Main info'),
            ]
        ]);
        $this->crud->addField([
            'label' => _t("Tags"),
            'type' => 'select2_multiple',
            'name' => 'tags', // the method that defines the relationship in your Model
            'entity' => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            'tab'             => _t('Main info'),
        ]);



        //Tab Locale Info
        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => _t('Name'),
                'type'  => 'text',
                'tab'           => _t('Localization'),
            ],
            [
                'name'  => 'seo_title',
                'label' => _t('SEO title'),
                'type'  => 'text',
                'tab'           => _t('Localization'),
            ],
            [
                'name'  => 'seo_h1',
                'label' => _t('SEO H1'),
                'type'  => 'text',
                'tab'           => _t('Localization'),
            ],
            [
                'name'  => 'seo_description',
                'label' => _t('SEO description'),
                'type'  => 'text',
                'tab'           => _t('Localization'),
            ],
            [
                'name'  => 'seo_keywords',
                'label' => _t('SEO keywords'),
                'type'  => 'text',
                'tab'           => _t('Localization'),
            ],
            [
                'name'  => 'short_description',
                'label' => _t('Short description'),
                'type'  => 'ckeditor',
                'tab'           => _t('Localization'),
            ],
            [
                'name'  => 'content',
                'label' => _t('Content'),
                'type'  => 'ckeditor',
                'tab'           => _t('Localization'),
            ],
        ]);
        $this->crud->addFields([
            [   // repeatable
                'tab'   => _t('FAQ'),
                'name'  => 'faq',
                'label' => _t('FAQ'),
                'disable_sortable' => true, //Конфликт сортабла с Вуси редакторами
                'type'  => 'repeatable',
                'fields' => [
                    [
                        'name'    => 'question',
                        'type'    => 'text',
                        'label'   => _t('question'),
                    ],
                    [
                        'name'  => 'answer',
                        'type'  => 'ckeditor',
                        'label' => _t('Answer'),
                    ],
                ],

                // optional
                'new_item_label'  => _t('Add FAQ'),
                'init_rows' => 0

            ]
        ]);




        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->crud->addColumns([
            [
                'name'      =>  'title',
                'title'     =>  _t('Title'),
                'type'      =>  'text',
                'hint'      =>  _t('For admin panel & slug generator'),
                'tab'           => _t('Main info'),
            ],
            [
                'name'  => 'status',
                'label' => 'Status',
                'type'  => 'boolean',
                // optionally override the Yes/No texts
                'options' => [
                    1 => '<i class="lar la-check-circle" style="color: green"></i>',
                    0 => '<i class="las la-times-circle" style="color: red"></i>'
                ]
            ],
            [
                'name'      =>  'slug',
                'title'     =>  _t('Slug'),
                'type'      =>  'text',
                'hint'      =>  _t('auto generate'),
                'tab'           => _t('Main info'),
            ],
            [
                'name'  =>  'thumbnail',
                'label' =>  'thumbnail',
                'type'  =>  'image',
                'prefix' => config('app.upload_patch'),
                'width' =>  '250px',
                'height'    =>  'auto'
            ],
            [
                'name'  => 'category_id',
                'label' => _t('Category'),
                'type'  => 'relationship',
                'entity'        => 'category', // the method that defines the relationship in your Model
                'attribute'     => 'title', // foreign key attribute that is shown to user
                'model'         => ArticleCategory::class,
            ],
            [
                'label' => _t("Tags"),
                'type' => 'relationship',
                'name' => 'tags', // the method that defines the relationship in your Model
                'entity' => 'tags', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
            ],
            [
                'name'  => 'seo_title',
                'label' => _t('SEO title'),
                'type'  => 'text',
            ],
            [
                'name'  => 'seo_h1',
                'label' => _t('SEO H1'),
                'type'  => 'text',
            ],
            [
                'name'  => 'seo_description',
                'label' => _t('SEO description'),
                'type'  => 'text',
            ],
            [
                'name'  => 'seo_keywords',
                'label' => _t('SEO keywords'),
                'type'  => 'text',
            ],
            [
                'name'  => 'short_description',
                'label' => _t('Short description'),
                'type' => 'textarea',
            ],
            [
                'name'  => 'content',
                'label' => _t('Content'),
                'type' => 'textarea',
            ],

        ]);


    }
}
