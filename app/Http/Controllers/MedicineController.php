<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineController extends Controller
{
    public function medicine(){
        return view('administrator/medicine/index');
    }
    
    public function medicineList(Request $request){
        $columns = array( 
            0 =>'barcode', 
            1 =>'medicine_name',
            2 =>'medicine_pharma',
            3 =>'medicine_cabinet',
            // 4 =>'unit_type',
            4 =>'unit_qty',
            5 =>'buy_price',
            6 =>'sell_price',
            7 =>'expiration_date',
            8 =>'added_by',
            9 =>'id',
        );
        
        $totalData = Medicine::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {          
        $posts = Medicine::select('medicines.id','medicine_name','medicine_pharma','medicine_cabinet','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                            DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                            ->join('users','medicines.user_id','users.id')->latest()
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $posts =  Medicine::select('medicines.id','medicine_name','medicine_pharma','medicine_cabinet','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                            DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                            ->join('users','medicines.user_id','users.id')->latest()
                            ->orWhere('medicine_name', 'LIKE',"%{$search}%")
                            ->orWhere('medicine_pharma', 'LIKE',"%{$search}%")
                            ->orWhere('medicine_cabinet', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();

        $totalFiltered = Medicine::select('medicines.id','medicine_name','medicine_pharma','medicine_cabinet','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                    DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                    ->join('users','medicines.user_id','users.id')->latest()
                    ->orWhere('medicine_name', 'LIKE',"%{$search}%")
                    ->orWhere('medicine_pharma', 'LIKE',"%{$search}%")
                    ->orWhere('medicine_cabinet', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($posts)) {
            foreach ($posts as $post) {

            $nestedData['barcode'] = $post->barcode;
            $nestedData['medicine_name'] = $post->medicine_name;
            $nestedData['medicine_pharma'] = $post->medicine_pharma;
            $nestedData['medicine_cabinet'] = $post->medicine_cabinet;
            // $nestedData['unit_type'] = $post->unit_type;
            $nestedData['unit_qty'] = $post->unit_qty;
            $nestedData['buy_price'] = $post->buy_price;
            $nestedData['sell_price'] = $post->sell_price;
            // $nestedData['barcode'] = $post->type;
            $nestedData['expiration_date'] = $post->expiration_date;
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

    public function store(Request $request){
        return Medicine::updateorcreate(['id'=>$request->id],[
            'user_id'=>auth()->user()->id,
            'medicine_name'=>$request->medicine_name,
            'medicine_pharma'=>$request->medicine_pharma,
            'medicine_cabinet'=>$request->medicine_cabinet,
            'unit_qty'=>$request->unit_qty,
            // 'unit_type'=>$request->unit_type,
            'buy_price'=>$request->buy_price,
            'sell_price'=>$request->sell_price,
            'barcode'=>empty($request->id)?$this->generateBarcodeNumber():$request->barcode,
            'expiration_date'=>$request->expiration_date,
        ]);
    }

    public function edit($id){
        return response()->json(
            Medicine::whereId($id)->with('user')->first()
        );
    }

    public function generateBarcodeNumber() {
        $number = mt_rand(1000000000, 9999999999).date("Ydm"); // better than rand()
    
        // call the same function if the barcode exists already
        if ($this->barcodeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }
    
        // otherwise, it's valid and can be used
        return $number;
    }
    
    public function barcodeNumberExists($barcode) {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return Medicine::whereBarcode($barcode)->exists();
    }
}
