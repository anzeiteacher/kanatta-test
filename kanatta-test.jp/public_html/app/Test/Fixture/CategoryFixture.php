<?php
class CategoryFixture extends CakeTestFixture {
    public $import = 'Category';
    public $records = array(
        array(
            'id' => 1,
            'name' => 'Music',
            'order' => 4,
            'show_top_flag' => 1
        ),
        array(
            'id' => 2,
            'name' => 'Movie',
            'order' => 3,
            'show_top_flag' => 1
        ),
        array(
            'id' => 3,
            'name' => 'Product',
            'order' => 2,
            'show_top_flag' => 0
        ),
        array(
            'id' => 4,
            'name' => 'Dance',
            'order' => 1,
            'show_top_flag' => 0
        ),
    );
}