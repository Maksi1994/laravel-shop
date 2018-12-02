<?
namespace App\Http\Traits;

class CategoryTrait {
    
    public function sortCategories($categories) {
        $sortArray = [];
        
        array_walk($categories, function($category) {
            if(is_array($sortArray[$category['parent_id']])) {
                $sortArray[$category['parent_id']][] = $category;
            } else {
                $sortArray[$category['parent_id']] = [$category];
            }
        });
    }
    
    public function getChildren($categoryId, $allCategories) {
        $sortedCategries = $this->sortCategories($allCategories);
        $categories = [];
                   
       array_walk(function($category) {
            return $categories[''];
        }, $sortedCategries));
        
        return $categories;
    }
}