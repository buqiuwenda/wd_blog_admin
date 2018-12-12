<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Member;
use App\Model\Tag;

class ResetController extends Controller
{
    protected $pageSizes = [
        25,50,100,200,500
    ];

    protected $ableStatus = [
       'enable' => [
          'name' => '启用',
          'class' => 'text-navy',
       ],
       'disable' => [
           'name' => '禁用',
           'class' => 'text-danger'
       ]
    ];

    protected $status = [
        1 => [
            'name' => '启用',
            'class' => 'text-navy',
        ],
        0 => [
            'name' => '禁用',
            'class' => 'text-danger'
        ]
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getList($model = 'category')
    {
        $data = [];

        if($model == 'category') {
            $category = Category::query()->select(['id', 'name'])->get();
        }else{
            $category = Member::query()->select(['id','name'])->get();
        }

        if($category){
            foreach($category->toArray() as $val){
                $data[$val['id']] = $val['name'];
            }
        }

        return $data;
    }



    protected function getTagList()
    {
        $data = [];

        $tags = Tag::query()->select(['id', 'tag'])->get();
        if($tags){
            foreach($tags->toArray() as $val){
                $data[$val['id']] = $val['tag'];
            }
        }

        return $data;
    }


}
