<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ExpenseController extends Controller{

    public function expenses(){
        $years = Expense::select(DB::raw('YEAR(created_at) as year'))->orderBy('year','DESC')->groupBy('year')->limit(5)->get();
        return view('administrator/expenses/index',compact('years'));
    }
    

    /**
     * 
     * 
     * need data for display infromative bargraph and pie graph
     * auto compute the cost of expenses in lastweek,last month
     * and whole year
     * 
     * 
     */

    public function barGraph($year){
        return response()->json(
            [
                'lastweek'=>Expense::select(DB::raw('sum(amount) as total'))
                ->where(DB::raw('YEAR(created_at)'),$year)
                ->whereBetween('created_at', 
                    [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                )->get(),
                'lastmonth'=>Expense::select(DB::raw('sum(amount) as total'))
                ->where(DB::raw('YEAR(created_at)'),$year)
                ->whereBetween('created_at', 
                [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]
                )->get(),
                'graph'=>Expense::select(DB::raw('sum(amount) as total, MONTH(created_at) as month'))
                ->where(DB::raw('YEAR(created_at)'),$year)
                ->groupBy('month')
                ->orderBy('month','ASC')
                ->get()
            ]
        );
    }


    /**
     * 
     * Display expenses accoidung to
     * filter method using year and month
     * 
     */
    public function expensesList($year,$month,Request $request){
        $columns = array( 
            0 =>'description', 
            1 =>'amount',
            2 =>'fullname',
            3 =>'pdate',
            4 =>'id',
        );
        
         $totalData = Expense::where(DB::raw('YEAR(expenses.created_at)'),$year)->where(DB::raw('MONTH(expenses.created_at)'),$month)->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {          
        $posts = Expense::select('expenses.id','amount','description','expenses.created_at',DB::raw('DATE(expenses.created_at) as pdate'),DB::raw("CONCAT(users.first_name,' ',users.last_name) as fullname"))
                            ->where(DB::raw('YEAR(expenses.created_at)'),$year)
                            ->where(DB::raw('MONTH(expenses.created_at)'),$month)
                            ->join('users','expenses.user_id','users.id')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $posts =  Expense::select('expenses.id','amount','description','expenses.created_at',DB::raw('DATE(expenses.created_at) as pdate'),DB::raw("CONCAT(users.first_name,' ',users.last_name) as fullname"))
                            ->join('users','expenses.user_id','users.id')
                            ->where(DB::raw('YEAR(expenses.created_at)'),$year)
                            ->where(DB::raw('MONTH(expenses.created_at)'),$month)
                            ->orWhere('description', 'LIKE',"%{$search}%")
                            ->orWhere('fullname', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();

        $totalFiltered = Expense::select('expenses.id','amount','description','expenses.created_at',DB::raw('DATE(expenses.created_at) as pdate'),DB::raw("CONCAT(users.first_name,' ',users.last_name) as fullname"))
                    ->join('users','medicines.user_id','users.id')
                    ->where(DB::raw('YEAR(expenses.created_at)'),$year)
                    ->where(DB::raw('MONTH(expenses.created_at)'),$month)
                    ->orWhere('description', 'LIKE',"%{$search}%")
                    ->orWhere('fullname', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($posts)) {
            foreach ($posts as $post) {

            $nestedData['description'] = $post->description;
            $nestedData['amount'] = $post->amount;
            $nestedData['fullname'] = $post->fullname;
            $nestedData['pdate'] = $post->pdate;
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
        // if ($month=='null') {
        //            return response()->json([
        //                 "data"=> Expense::select('expenses.id','amount','description','expenses.created_at',DB::raw('DATE(expenses.created_at) as pdate'),DB::raw("CONCAT(users.first_name,' ',users.last_name) as fullname"))
        //                 ->join('users','expenses.user_id','users.id')->latest()
        //                 ->where(DB::raw('YEAR(expenses.created_at)'),$year)
        //                 ->get()
        //             ]);
        // } else {
        //            return response()->json([
        //                 "data"=> Expense::select('expenses.id','amount','description','expenses.created_at',DB::raw('DATE(expenses.created_at) as pdate'),DB::raw("CONCAT(users.first_name,' ',users.last_name) as fullname"))
        //                 ->join('users','expenses.user_id','users.id')->latest()
        //                 ->where(DB::raw('YEAR(expenses.created_at)'),$year)
        //                 ->where(DB::raw('MONTH(expenses.created_at)'),$month)
        //                 ->get()
        //             ]);
        // }
        

    }



    /**
     * 
     * storing data
     * 
     * */
    public function store(Request $request){

        $request->validate([
            'amount'=>'required',
            'description'=>'required' 
        ]);

        Expense::updateorcreate(['id'=>$request->id],[
            'user_id'=>auth()->user()->id,
            'amount'=>$request->amount,
            'description'=>$request->description
        ]);
    }

    /**
     * 
     * retrieve data
     * 
     */

    public function edit(Expense $expense){
        return response()->json($expense);
    }



    /**
     * 
     * Generate report using date range
     * ->today 
     * ->yesterday
     * ->last 7 days
     * ->this month
     * ->last month
     * ->or custom date range
     * 
     */

    public function generateReport($start,$end,$type){
        $startDate=date('Y-m-d',strtotime($start));
        $endDate=date('Y-m-d',strtotime($end));
        $data = Expense::select('expenses.id','amount','description',DB::raw("CONCAT(users.first_name,' ',users.last_name) as fullname"))
        ->join('users','expenses.user_id','users.id')
        ->whereDate('expenses.created_at','>=',$startDate)
        ->whereDate('expenses.created_at','<=',$endDate)
        ->get();
        if ($type=='print') {
            return view('administrator/expenses/report',compact('data','startDate','endDate'));
        } else {
            $pdf = PDF::loadView('administrator/expenses/report',compact('data','startDate','endDate'));
            return $pdf->download('EXPENSES-REPORT-Generated'.date("F j, Y, g:i a").'.pdf');
        }
        
    }
}
