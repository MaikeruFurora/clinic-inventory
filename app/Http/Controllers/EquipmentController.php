<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\BinaryOp\Equal;

class EquipmentController extends Controller
{
    public function equipment(){
        return view('administrator/equipment/index');
    }
    public function equipmentList(Request $request){
        $columns = array( 
            0 =>'id', 
            1 =>'name', 
            2 =>'quantity',
            3 =>'description',
            4 =>'created_at',
            5 =>'added_by',
            6 =>'id',
        );
        
        $totalData = Equipment::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {          
        $posts = Equipment::select('equipment.id','name','quantity','description','equipment.created_at',
                            DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                            ->join('users','equipment.user_id','users.id')->latest()
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $posts =  Equipment::select('equipment.id','name','quantity','description','equipment.created_at',
                            DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                            ->join('users','equipment.user_id','users.id')->latest()
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('description', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();

        $totalFiltered = Equipment::select('name','quantity','description','equipment.created_at',
                    DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                    ->join('users','equipment.user_id','users.id')->latest()
                    ->orWhere('name', 'LIKE',"%{$search}%")
                    ->orWhere('description', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($posts)) {
            foreach ($posts as $key => $post) {

            $nestedData['id'] = $post->id;
            $nestedData['name'] = $post->name;
            $nestedData['quantity'] = $post->quantity;
            $nestedData['description'] = $post->description;
            $nestedData['created_at'] = $post->created_at->format("F j, Y");
            $nestedData['added_by'] = $post->added_by;
            $nestedData['id'] = $post->id;
            // $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
            // $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                    // &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
            $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );

        echo json_encode($json_data); 
    }
    public function edit($id){
        return response()->json(Equipment::whereId($id)->first());
    }
    public function store(Request $request){
        return Equipment::updateorcreate(['id'=>$request->id],[
            'user_id'=>auth()->user()->id,
            'name'=>$request->name, 
            'quantity'=>$request->quantity,
            'description'=>$request->description, 
        ]);
    }
}
