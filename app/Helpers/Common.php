<?php

namespace App\Helpers;
class Common
{
  public static function encryptLink($inputObj){
    $params = isset($inputObj->params) ? $inputObj->params : '';
    $url = url($inputObj->url);
    if($params!=''){
      $link = $url.'?eq='.urlencode(\Crypt::encrypt($inputObj->params));
      return $link;
    }
    return $url;
  }

  public static function decryptLink($input){
    $decrString = urldecode(\Crypt::decrypt($input));
    $reqArr = [];
    if(strpos($decrString,"=")!==false){
      $keyVal = explode("&",$decrString);
      if(count($keyVal) > 0){
        foreach($keyVal as $v):
          $kvarr = explode("=",$v);
          if(count($kvarr)>0){
            $reqArr[$kvarr[0]] = $kvarr[1];
          }
        endforeach;
      }
    }
    return $reqArr;
  }
  

  public static function buildTree($items) {
      $childs = array();
      foreach($items as $item)
          $childs[$item->parent_id][] = $item;
      foreach($items as $item) if (isset($childs[$item->id]))
          $item->childs = $childs[$item->id];
      return $childs[0];
  }

  public static function printTree($tree, $r = 0, $p = null,$sel=0) {
      foreach ($tree as $i => $t) {
          $dash = ($t->parent_id == 0) ? '' : str_repeat('-', $r) .' ';
          $selected = $sel==$t->id ? 'selected':'';
          echo '<option value="'.$t->id.'" '.$selected.'>&nbsp;'. $dash.$t->cat_name.'</option>';
          if (isset($t->childs)) {
              self::printTree($t->childs, ++$r, $t->parent_id,$sel);
              --$r;
          }
      }
  }

  public static function getParentId($curreId = 0){
    $data = \App\Models\Category::select('parent_id','id')->where('id',$curreId)->first();
    if($data){
      if($data->parent_id > 0){
         return self::getParentId($data->parent_id);
      }
      return $data->id;
    }
    return 0;
  }

  public static function siteCategories(){
    $categories = \Cache::rememberForever('site-categories',function(){
      return \App\Models\Category::select('id','cat_name','parent_id')->where('status',1)->get();
    });
    return $categories;
  }

  public static function productCount(){
    $categories = \Cache::rememberForever('product-count',function(){
      return \App\Models\Product::where('status',1)->count();
    });
    return $categories;
  }

  public static function categoryCount(){
    $categories = \Cache::rememberForever('category-count',function(){
      return \App\Models\Category::where('status',1)->count();
    });
    return $categories;
  }

  public static function showPage(){
    $pages = \App\Models\Pages::select('title','slug')->orderBy('id','DESC')->where('status',1)->get();
    if(count($pages) > 0){
      return $pages;
    }
    return $pages = 0;
  } 

  public static function randomMerchantId($userId){
    return substr(str_shuffle($userId.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,3).time().rand(111,999);
  }

  public static function getState($id){
    $state = \App\Models\State::select('name')->Where('id',$id)->first();
    return $state;
  }

  public static function getCity($id){
    $city = \App\Models\City::select('name')->Where('id',$id)->first();
    return $city;
  }

  public static function orderCount(){
    $categories = \Cache::rememberForever('order-count',function(){
      return \App\Models\Order::where('order_status',1)->count();
    });
    return $categories;
  }

}
