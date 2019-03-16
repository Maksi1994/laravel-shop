<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $guarded = [];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function scopeChildrenIds($query, $categoryId) {
      $allCategories = $query->get();
      $groupedCategories = [];
      $targetCategories = [$categoryId];

      $allCategories->each(function($category) use (&$groupedCategories) {
         if (!array_key_exists($category->parent_id, $groupedCategories)) {
           $groupedCategories[$category->parent_id] = [];
         }

         $groupedCategories[$category->parent_id][] = [
           'id' => $category->id,
           'name' => $category->name,
           'parent_id'=> $category->parent_id
         ];
      });

      $this->catByParent($groupedCategories, $categoryId, $targetCategories);

      return $targetCategories;
    }

    private function catByParent(Array $all, $parentId, &$targetArray) {
      if (array_key_exists($parentId, $all)) {
        foreach ($all[$parentId] as $key => $category) {
          $targetArray[] = $category['id'];

          if (array_key_exists($category['id'], $all)) {
            $this->catByParent($all, $category['id'], $targetArray);
          }
        }
      }
    }
}
