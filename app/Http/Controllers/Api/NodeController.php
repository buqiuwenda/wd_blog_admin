<?php
/**
 * Class NodeController
 * @package App\Http\Controllers\Api
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/22 10:32 AM
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Node;
use App\Model\Menu;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    public function getTreeNodes(Request $request)
    {
        if(!empty($request->get('status'))){
            $is_status = $request->get('status');
        }else{
            $is_status = 0;
        }


        if(!empty($request->get('node_id'))){
            $node_id = explode(',',$request->get('node_id'));
        }else{
            $node_id = [];
        }

        $tmpDataTwo = [];
        $menus = Menu::query()->orderBy('parent_id', 'asc')->get();

        if(empty($menus)){
            return $tmpDataTwo;
        }


        if($is_status) {
            $nodes = Node::query()->where('status', '=', 'enable')->orderBy('parent_id', 'asc')->get();
        }else{
            $nodes = Node::query()->orderBy('parent_id', 'asc')->get();
        }


        if($nodes){
            $data = [];
            foreach($nodes->toArray() as $val){
                if($val['parent_id'] == '0'){
                    $data[$val['id']] = [
                        'id' => $val['id'],
                        'name' => $val['name'],
                        'routing' => $val['routing'],
                        'children'    => []
                    ];
                }else{
                    $tmp = [
                        'id' => $val['id'],
                        'name' => $val['name'],
                        'routing' => $val['routing'],
                    ];

                    if($node_id && in_array($val['id'], $node_id)){
                        $tmp['checked'] = true;
                        $data[$val['parent_id']]['open'] = true;
                    }

                    $data[$val['parent_id']]['children'][] = $tmp;
                }
            }

            $tmpData = [];
            foreach($data as $val){
                $tmpData[$val['routing']] = $val;
            }


            foreach($menus as $vo){
                if($vo['parent_id'] == '0'){
                    $tmpDataTwo[$vo['id']] = [
                       'id' => $vo['id'],
                       'name' => $vo['name'],
                       'routing' => $vo['routing'],
                       'open' => true,
                       'children'  => []
                    ];
                }else{
                    if(!empty($tmpData[$vo['routing']])) {
                        $tmp = $tmpData[$vo['routing']];

                        $tmpDataTwo[$vo['parent_id']]['children'][] = $tmp;
                    }else{
                        $tmp = [
                          'id' => $vo['id'],
                          'name' => $vo['name'],
                          'routing' => $vo['routing']
                        ];

                        $tmpDataTwo[$vo['parent_id']]['children'][] = $tmp;
                    }
                }
            }

        }

        return array_values($tmpDataTwo);
    }
}