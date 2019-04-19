<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeGetList($query, $params)
    {
        $filterType = $params['filter'];
        $order = !empty($params['order']) ? $params['order'] : 'desc';

        if ($filterType === 'comments') {
            return $query->with('author')->orderBy('created_at', $order);
        } else if ($filterType === 'users') {
            return User::withCount('comments')->has('comments')->orderBy('comments_count', $order);
        } else if ($filterType === 'products') {
            return Product::withCount('comments')->has('comments')->orderBy('comments_count', $order);
        } else if ($filterType === 'user_comments') {
            return $query->with('author')->where('user_id', $params['user_id'])->orderBy('created_at', $order);
        }
    }
}
