<?php

function makeCategorySection($items)
{
    $data = [
        0 => [],
        1 => [],
        2 => [],
        3 => [],
        4 => [],
    ];
    foreach ($items as $value) {
        array_push($data[0], ['id' => $value->id, 'title' => $value->title, 'slug' => $value->slug, 'parent' => $value->parent_id == null ? 0 : $value->parent_id, 'children' => count($value->children) > 0 ? true : false]);

        foreach ($value->children as $val) {
            array_push($data[1], ['id' => $val->id, 'slug' => $val->slug, 'parent' => $val->parent_id == null ? 0 : $val->parent_id, 'children' => count($val->children) > 0 ? true : false]);

            foreach ($val->children as $val2) {
                array_push($data[2], ['id' => $val2->id, 'slug' => $val2->slug, 'parent' => $val2->parent_id == null ? 0 : $val2->parent_id, 'children' => count($val2->children) > 0 ? true : false]);

                foreach ($val2->children as $val3) {
                    array_push($data[3], ['id' => $val3->id, 'slug' => $val3->slug, 'parent' => $val3->parent_id == null ? 0 : $val3->parent_id, 'children' => count($val3->children) > 0 ? true : false]);

                    foreach ($val3->children as $val4) {
                        array_push($data[4], ['id' => $val4->id, 'slug' => $val4->slug, 'parent' => $val4->parent_id == null ? 0 : $val4->parent_id, 'children' => count($val4->children) > 0 ? true : false]);

                    }
                }
            }
        }
    }

    return $data;
}

function unit_calculate($value, $scale)
{
    if ($scale == 'کیلوگرم') {
        if ($value >= 1000) {
            return (int)$value / 1000 . ' تن ';
        }
    }

    return $value . ' ' .$scale . ' ';

}
