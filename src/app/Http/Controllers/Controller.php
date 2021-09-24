<?php

namespace Aldwyn\BlogCrm\App\Http\Controllers;

use App\Jobs\CategoryToSeries;
use App\Models\CharacteristicList;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Notifications\Telegram;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Notification;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function crutch()
    {

//        $brandId = getSettings('brand_characteristic')['brand_characteristic'];
//        $conditionCategoryId  = getSettings('condition_category')['condition_category'];
//        $seriesId = getSettings('model_characteristic')['model_characteristic'];
//        $categories = ProductCategory::where('parent_id', $conditionCategoryId)->get();
//        $brands = CharacteristicList::where('characteristic_id', $brandId)->get();
//        $brandCategoryIds = [];
//        foreach ($categories AS $category){
//            $qq =  $brands->firstWhere('name',$category->name);
//            if ($qq){
//                $category->characteristic_list_id = $qq->id;
//                unset($qq);
//                $category->save();
//                $brandCategoryIds[]=$category->id;
//            }
//        }
//        foreach ($brandCategoryIds AS $seriesCatId){
//            $seriesCategories = ProductCategory::where('parent_id', $seriesCatId)->get();
//            foreach ($seriesCategories AS $category){
//                CategoryToSeries::dispatch(
//                    $category,
//                    ['Серія', 'серія','Серия','серия'],
//                    $seriesId
//                );
//            }
//        }

//        foreach ($brands AS $brand){
//            dump($brand->name);
//        }
    }
}
