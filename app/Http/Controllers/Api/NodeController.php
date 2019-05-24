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

        if($is_status) {
            $nodes = Node::query()->where('status', '=', 'enable')->orderBy('parent_id', 'asc')->get();
        }else{
            $nodes = Node::query()->orderBy('parent_id', 'asc')->get();
        }

        $data = [];
        if($nodes){

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


        }

        return array_values($data);
    }
}