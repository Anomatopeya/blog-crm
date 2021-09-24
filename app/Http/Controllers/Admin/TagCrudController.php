<?php

namespace Aldwyn\BlogCrm\App\Http\Controllers\Admin;

use Aldwyn\BlogCrm\App\Http\Requests\TagRequest;
use Aldwyn\BlogCrm\App\Models\Tag;
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
        CRUD::setModel(Tag::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tag');
        CRUD::setEntityNameStrings(_('tag'), _('tags'));
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
                'label'     =>  _('Name'),
                'type'      =>  'text',
            ]);
        $this->crud->addColumn([
                'name'      =>  'slug',
                'label'     =>  _('Slug'),
                'type'      =>  'text',
            ]);
        $this->crud->addColumn([
                'name'      =>  'seo_title',
                'label'     =>  _('Title'),
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
            'label'       => _('city_tag'),
            'type'        => 'radio',
            'options'     => [
                // the key will be stored in the db, the value will be shown as label;
                0 => _("Normal tag"),
                1 => _("Its a City")
            ],
            'tab'           => _('Main info'),
            'inline'      => true,
        ]);
        /** Main Info Tab **/
        $this->crud->addField([
            'name'      =>  'title',
            'title'     =>  _('Name'),
            'type'      =>  'text',
            'hint'      =>  _('For admin panel'),
            'tab'           => _('Main info'),

        ])->setRequiredFields(TagRequest::class);
        $this->crud->addField([
            'name'      =>  'slug',
            'title'     =>  _('Slug'),
            'type'      =>  'text',
            'hint'      =>  _('auto generate'),
            'tab'           => _('Main info'),
        ])->setRequiredFields(TagRequest::class);
        $this->crud->addField([
            'name' => 'thumbnail',
            'label' => _('thumbnail'),
            'type' => 'browse',
            'mime_types' => ['image'],
            'tab'           => _('Main info'),
        ]);
        $this->crud->addField([
            'name' => 'map',
            'label' => _('Google map'),
            'type' => 'text',
            'tab'           => _('Main info'),
        ]);

        /** Localize tab */
        $this->crud->addFields([
            [
                'name'      =>  'name',
                'title'     =>  _('Name'),
                'type'      =>  'text',
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

        $this->crud->addFields([
            [
                'name'  => 'faq_title',
                'label' => _('Faq_title'),
                'type'  => 'text',
                'tab'           => _('FAQ'),
            ],
            [   // repeatable
                'tab'   => _('FAQ'),
                'name'  => 'faq',
                'label' => _('FAQ'),
                'disable_sortable' => true, //Конфликт сортабла с Вуси редакторами
                'type'  => 'repeatable',
                'fields' => [
                    [
                        'name'    => 'question',
                        'type'    => 'text',
                        'label'   => _('question'),
                    ],
                    [
                        'name'  => 'answer',
                        'type'  => 'ckeditor',
                        'label' => _('Answer'),
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
