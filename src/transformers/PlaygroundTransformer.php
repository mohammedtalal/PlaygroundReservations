<?php

namespace Src\Transformers;

class PostTransformer extends Transformer {
    
    // Transform a collection of posts
    public function transform($post) {
        return [
            'title' =>  $post['title'],
            'body'  =>  $post['body'],
            'active'=>  (boolean) $post['some_pool']
        ];
    }

}