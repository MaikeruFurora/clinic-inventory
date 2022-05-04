<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MedicineController extends Controller
{

    private $dateNow;
    private $totalExpired;
    private $totalRunningOutOfStock;

    public function __construct()
    {
        $this->dateNow=Carbon::now();
        $this->totalExpired=Medicine::whereDate('expiration_date', '>', $this->dateNow->toDateString())->count();
        $this->totalRunningOutOfStock=Medicine::where('unit_qty','<',20)->count();
    }

    public function medicine(){
        return view('administrator/medicine/index',[
            'te'=>$this->totalExpired,
            'tr'=>$this->totalRunningOutOfStock,
        ]);
    }
    
    public function medicineList(Request $request){
        $columns = array( 
            0 =>'barcode', 
            1 =>'medicine_name',
            2 =>'stock',
            // 4 =>'unit_type',
            3 =>'unit_qty',
            4 =>'buy_price',
            5 =>'sell_price',
            6 =>'expiration_date',
            7 =>'added_by',
            8 =>'id',
        );
        
        $totalData = Medicine::whereDate('expiration_date', '<', $this->dateNow->toDateString())->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {          
        $posts = Medicine::select('medicines.id','medicine_name','stock','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                            DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                            ->whereDate('expiration_date', '<', $this->dateNow->toDateString())
                            ->join('users','medicines.user_id','users.id')->latest()
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $posts =  Medicine::select('medicines.id','medicine_name','stock','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                            DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                            ->join('users','medicines.user_id','users.id')->latest()
                            ->whereDate('expiration_date', '<', $this->dateNow->toDateString())
                            ->orWhere('medicine_name', 'LIKE',"%{$search}%")
                            ->orWhere('stock', 'LIKE',"%{$search}%")
                            ->orWhere('barcode', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();

        $totalFiltered = Medicine::select('medicines.id','medicine_name','stock','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                    DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                    ->join('users','medicines.user_id','users.id')->latest()
                    ->whereDate('expiration_date', '<', $this->dateNow->toDateString())
                    ->orWhere('medicine_name', 'LIKE',"%{$search}%")
                    ->orWhere('stock', 'LIKE',"%{$search}%")
                    ->orWhere('barcode', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($posts)) {
            foreach ($posts as $post) {

            $nestedData['barcode'] = $post->barcode;
            $nestedData['medicine_name'] = $post->medicine_name;
            $nestedData['stock'] = $post->stock;
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
            'stock'=>$request->stock,
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


    //expired
    public function expired(){
        return view('administrator/medicine/expired',[
            'te'=>$this->totalExpired,
            'tr'=>$this->totalRunningOutOfStock,
        ]);
    }

    public function expiredPrint(){
        $type='Expired';
        $data =  Medicine::whereDate('expiration_date', '>', $this->dateNow->toDateString())->get();
        return view('administrator/medicine/print',compact('data','type'));
    }


    public function expiredList(Request $request){
        $columns = array( 
            0 =>'barcode', 
            1 =>'medicine_name',
            2 =>'stock',
            // 4 =>'unit_type',
            3 =>'unit_qty',
            4 =>'buy_price',
            5 =>'sell_price',
            6 =>'expiration_date',
            7 =>'added_by',
        );
        
        $totalData = Medicine::whereDate('expiration_date', '>', $this->dateNow->toDateString())->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {          
        $posts = Medicine::select('medicines.id','medicine_name','stock','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                            DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                            ->whereDate('expiration_date', '>', $this->dateNow->toDateString())
                            ->join('users','medicines.user_id','users.id')->latest()
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $posts =  Medicine::select('medicines.id','medicine_name','stock','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                            DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                            ->join('users','medicines.user_id','users.id')->latest()
                            ->whereDate('expiration_date', '>', $this->dateNow->toDateString())
                            ->orWhere('medicine_name', 'LIKE',"%{$search}%")
                            ->orWhere('stock', 'LIKE',"%{$search}%")
                            ->orWhere('barcode', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();

        $totalFiltered = Medicine::select('medicines.id','medicine_name','stock','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                    DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                    ->join('users','medicines.user_id','users.id')->latest()
                    ->whereDate('expiration_date', '>', $this->dateNow->toDateString())
                    ->orWhere('medicine_name', 'LIKE',"%{$search}%")
                    ->orWhere('stock', 'LIKE',"%{$search}%")
                    ->orWhere('barcode', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($posts)) {
            foreach ($posts as $post) {

            $nestedData['barcode'] = $post->barcode;
            $nestedData['medicine_name'] = $post->medicine_name;
            $nestedData['stock'] = $post->stock;
            // $nestedData['unit_type'] = $post->unit_type;
            $nestedData['unit_qty'] = $post->unit_qty;
            $nestedData['buy_price'] = $post->buy_price;
            $nestedData['sell_price'] = $post->sell_price;
            // $nestedData['barcode'] = $post->type;
            $nestedData['expiration_date'] = $post->expiration_date;
            $nestedData['added_by'] = $post->added_by;
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

    public function runningOutOfStock(){
        return view('administrator/medicine/runningOutOfStock',[
            'te'=>$this->totalExpired,
            'tr'=>$this->totalRunningOutOfStock,
        ]);
    }

    public function runningOutOfStockPrint(){
        $type = 'Running out of stock';
        $data = Medicine::where('unit_qty','<',20)->get();
        return view('administrator/medicine/print',compact('data','type'));
    }

    public function runningOutOfStockList(Request $request){
        $columns = array( 
            0 =>'barcode', 
            1 =>'medicine_name',
            2 =>'stock',
            // 4 =>'unit_type',
            3 =>'unit_qty',
            4 =>'buy_price',
            5 =>'sell_price',
            6 =>'expiration_date',
            7 =>'added_by',
            8 =>'id',
        );
        
        $totalData = Medicine::where('unit_qty','<',11)->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {          
        $posts = Medicine::select('medicines.id','medicine_name','stock','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                            DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                            ->where('unit_qty','<',20)
                            ->join('users','medicines.user_id','users.id')->latest()
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $posts =  Medicine::select('medicines.id','medicine_name','stock','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                            DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                            ->join('users','medicines.user_id','users.id')->latest()
                            ->where('unit_qty','<',20)
                            ->orWhere('medicine_name', 'LIKE',"%{$search}%")
                            ->orWhere('stock', 'LIKE',"%{$search}%")
                            ->orWhere('barcode', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();

        $totalFiltered = Medicine::select('medicines.id','medicine_name','stock','unit_qty','buy_price','sell_price','barcode','expiration_date','medicines.created_at',
                    DB::raw("CONCAT(users.first_name,' ',users.last_name) as added_by"))
                    ->join('users','medicines.user_id','users.id')->latest()
                    ->where('unit_qty','<',20)
                    ->orWhere('medicine_name', 'LIKE',"%{$search}%")
                    ->orWhere('stock', 'LIKE',"%{$search}%")
                    ->orWhere('barcode', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($posts)) {
            foreach ($posts as $post) {

            $nestedData['barcode'] = $post->barcode;
            $nestedData['medicine_name'] = $post->medicine_name;
            $nestedData['stock'] = $post->stock;
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
}
