<?php
namespace Src\Transformers;

abstract class Transformer {

    // Transform a collection of posts
    public function transformCollection(array $item) {
        return array_map([$this, 'transform'], $item); 
    }

    public abstract function transform($item);

}