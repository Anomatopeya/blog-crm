<?php

namespace Aldwyn\BlogCrm\App\Http\Controllers\Admin;

use Aldwyn\BlogCrm\App\Http\Requests\ArticleCategoryRequest;
use Aldwyn\BlogCrm\App\Models\ArticleCategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArticleCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ArticleCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ReorderOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(ArticleCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/articlecategory');
        CRUD::setEntityNameStrings(_('backpack.articlecategory'), _('backend.articlecategories'));
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
            'label'=> _('Title'),
            'type' =>'text'
        ]);
        $this->crud->addColumn([
            'name'  => 'status',
            'label' => _('Status'),
            'type'  => 'boolean',
            // optionally override the Yes/No texts
            'options' => [
                1 => '<i class="lar la-check-circle" style="color: green"></i>',
                0 => '<i class="las la-times-circle" style="color: red"></i>'
            ]
        ]);
        $this->crud->addColumn([
            'name'  =>  'thumbnail',
            'label' =>  _('Preview'),
            'type'  =>  'image',
            'prefix' => config('app.upload_patch'),
            'width' =>  '100px',
            'height'    =>  'auto'

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
        CRUD::setValidation(ArticleCategoryRequest::class);

        //Tab Main Info
        $this->crud->addFields([
            [
                'name'  => 'status',
                'label' => _('Publish status'),
                'type'  => 'checkbox',
                'tab'           => _('Main info'),
            ],
            [
                'name'      =>  'title',
                'title'     =>  _('Title'),
                'type'      =>  'text',
                'hint'      =>  _('For admin panel & slug generator'),
                'tab'           => _('Main info'),
            ],
            [
                'name'      =>  'slug',
                'title'     =>  _('Slug'),
                'type'      =>  'text',
                'hint'      =>  _('auto generate'),
                'tab'           => _('Main info'),
            ],
            [
                'name' => 'thumbnail',
                'label' => _('Preview'),
                'type' => 'browse',
                'mime_types' => ['image'],
                'tab'           => _('Main info'),
            ]
        ]);
        $this->crud->addField([
            'label' => _("Tags"),
            'type' => 'select2_multiple',
            'name' => 'tags', // the method that defines the relationship in your Model
            'entity' => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            'tab'             => _('Main info'),
        ]);



        //Tab Locale Info
        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => _('name'),
                'type'  => 'text',
                'tab'           => _('Localization'),
            ],
            [
                'name'  => 'seo_title',
                'label' => _('SEO title'),
                'type'  => 'text',
                'tab'           => _('Localization'),
            ],
            [
                'name'  => 'seo_h1',
                'label' => _('SEO H1'),
                'type'  => 'text',
                'tab'           => _('Localization'),
            ],
            [
                'name'  => 'seo_description',
                'label' => _('SEO description'),
                'type'  => 'text',
                'tab'           => _('Localization'),
            ],
            [
                'name'  => 'seo_keywords',
                'label' => _('SEO keywords'),
                'type'  => 'text',
                'tab'           => _('Localization'),
            ],
            [
                'name'  => 'short_description',
                'label' => _('Short description'),
                'type'  => 'ckeditor',
                'tab'           => _('Localization'),
            ],
            [
                'name'  => 'content',
                'label' => _('Content'),
                'type'  => 'ckeditor',
                'tab'           => _('Localization'),
            ],
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

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'title');
        $this->crud->set('reorder.status', 'status');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 5);
    }

    protected function setupShowOperation()
    {
        $this->crud->addColumns([
            [
                'name'      =>  'title',
                'title'     =>  _('Title'),
                'type'      =>  'text',
                'hint'      =>  _('For admin panel & slug generator'),
                'tab'           => _('Main info'),
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
                'title'     =>  _('Slug'),
                'type'      =>  'text',
                'hint'      =>  _('auto generate'),
                'tab'           => _('Main info'),
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
                'label' => _("Tags"),
                'type' => 'relationship',
                'name' => 'tags', // the method that defines the relationship in your Model
                'entity' => 'tags', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
            ],
            [
                'name'  => 'seo_title',
                'label' => _('SEO title'),
                'type'  => 'text',
            ],
            [
                'name'  => 'seo_h1',
                'label' => _('SEO H1'),
                'type'  => 'text',
            ],
            [
                'name'  => 'seo_description',
                'label' => _('SEO description'),
                'type'  => 'text',
            ],
            [
                'name'  => 'seo_keywords',
                'label' => _('SEO keywords'),
                'type'  => 'text',
            ],
            [
                'name'  => 'short_description',
                'label' => _('Short description'),
                'type' => 'textarea',
            ],
            [
                'name'  => 'content',
                'label' => _('Content'),
                'type' => 'textarea',
            ],
        ]);
    }
}
