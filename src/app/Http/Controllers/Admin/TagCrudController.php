<?php

namespace Aldwyn\BlogCrm\App\Http\Controllers\Admin;

use App\Http\Requests\TagRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\CrudPanel\Traits\Reorder;

/**
 * Class TagCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TagCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
//    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ReorderOperation;
    use Reorder;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Tag::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tag');
        CRUD::setEntityNameStrings(_t('tag'), _t('tags'));
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
                'name'      =>  'title',
                'label'     =>  _t('Name'),
                'type'      =>  'text',
            ]);
        $this->crud->addColumn([
                'name'      =>  'slug',
                'label'     =>  _t('Slug'),
                'type'      =>  'text',
            ]);
        $this->crud->addColumn([
                'name'      =>  'seo_title',
                'label'     =>  _t('Title'),
                'type'      =>  'text',
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
        CRUD::setValidation(TagRequest::class);
        $this->crud->addField( [
            'name'        => 'city_tag', // the name of the db column
            'label'       => _t('city_tag'),
            'type'        => 'radio',
            'options'     => [
                // the key will be stored in the db, the value will be shown as label;
                0 => _t("Normal tag"),
                1 => _t("Its a City")
            ],
            'tab'           => _t('Main info'),
            'inline'      => true,
        ]);
        /** Main Info Tab **/
        $this->crud->addField([
            'name'      =>  'title',
            'title'     =>  _t('Name'),
            'type'      =>  'text',
            'hint'      =>  _t('For admin panel'),
            'tab'           => _t('Main info'),

        ])->setRequiredFields(TagRequest::class);
        $this->crud->addField([
            'name'      =>  'slug',
            'title'     =>  _t('Slug'),
            'type'      =>  'text',
            'hint'      =>  _t('auto generate'),
            'tab'           => _t('Main info'),
        ])->setRequiredFields(TagRequest::class);
        $this->crud->addField([
            'name' => 'thumbnail',
            'label' => _t('thumbnail'),
            'type' => 'browse',
            'mime_types' => ['image'],
            'tab'           => _t('Main info'),
        ]);
        $this->crud->addField([
            'name' => 'map',
            'label' => _t('Google map'),
            'type' => 'text',
            'tab'           => _t('Main info'),
        ]);

        /** Localize tab */
        $this->crud->addFields([
            [
                'name'      =>  'name',
                'title'     =>  _t('Name'),
                'type'      =>  'text',
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
            [
                'name'  => 'faq_title',
                'label' => _t('Faq_title'),
                'type'  => 'text',
                'tab'           => _t('FAQ'),
            ],
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

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        $this->crud->set('reorder.status', 'city_tag');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 1);
    }
}
