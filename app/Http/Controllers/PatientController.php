<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function patient(){
        return view('administrator/patient/index');
    }

    public function patientList(Request $request){
            $columns = array( 
                0 =>'id', 
                1 =>'fullname',
                2 =>'date_of_birth',
                3=> 'status',
                4=> 'sex',
                5=> 'address',
                6=> 'contact_no',
            );

            $totalData = Patient::count();

            $totalFiltered = $totalData; 

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value')))
            {            
            $posts = Patient::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->latest()
                    ->get();
            }
            else {
            $search = $request->input('search.value'); 

            $posts =  Patient::where('id','LIKE',"%{$search}%")
                        ->orWhere('first_name', 'LIKE',"%{$search}%")
                        ->orWhere('last_name', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->latest()
                        ->get();

            $totalFiltered = Patient::where('id','LIKE',"%{$search}%")
                        ->orWhere('first_name', 'LIKE',"%{$search}%")
                        ->orWhere('last_name', 'LIKE',"%{$search}%")
                        ->count();
            }

            $data = array();
            if(!empty($posts)) {
                foreach ($posts as $post) {

                $nestedData['id'] = $post->id;
                $nestedData['fullname'] = $post->first_name.' '.$post->last_name;
                $nestedData['date_of_birth'] = $post->date_of_birth;
                $nestedData['status'] = $post->status;
                $nestedData['sex'] = $post->sex;
                $nestedData['address'] = $post->address;
                $nestedData['contact_no'] = $post->contact_no;
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

    public function patientStore(Request $request){
        return Patient::updateorcreate(['id'=>$request->id],[
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'date_of_birth'=>$request->date_of_birth,
            'status'=>$request->status,
            'sex'=>$request->sex,
            'address'=>$request->address,
            'contact_no'=>$request->contact_no,
        ]);
    }

    public function patientEdit(Patient $patient){
        return response()->json($patient);
    }


    // ---- END OF PATIENT FUNCTION

    public function medicalRecord($id){
         $patient = Patient::whereId($id)->with('medicalRecords')->first();
        return view('administrator/patient/medicalRecord',compact('patient'));
    }

    public function medicalStore(Request $request){
        return MedicalRecord::updateorcreate(['id'=>$request->id],[
            'patient_id'=>$request->patient_id,
            'blood_pressure'=>$request->blood_pressure,
            'temperature'=>$request->temperature,
            'pulse'=>$request->pulse,
            'respiratory_rate'=>$request->respiratory_rate,
            'height'=>$request->height,
            'weight'=>$request->weight,
            'symptom'=>$request->symptom,
            'details'=>$request->details,
            'treatment'=>$request->treatment,
            'remarks'=>$request->remarks,
        ]);
    }

    public function medicalRecordList($id){
        $data=Patient::whereId($id)->with('medicalRecords')->first();
        $arrData = array();
        foreach ($data->medicalRecords as $key => $value) {
            $arr=array();
            $arr['no']= ++$key;
            $arr['id']=$value->id;
            $arr['created_at']=$value->created_at->format("F j, Y");
            $arr['patient_id']=$value->patient_id;
            $arr['blood_pressure']=$value->blood_pressure;
            $arr['temperature']=$value->temperature;
            $arr['pulse']=$value->pulse;
            $arr['respiratory_rate']=$value->respiratory_rate;
            $arr['height']=$value->height;
            $arr['weight']=$value->weight;
            $arr['symptom']=$value->symptom;
            $arr['details']=$value->details;
            $arr['treatment']=$value->treatment;
            $arr['remarks']=$value->remarks;
            $arrData[]=$arr;
        }
        return response()->json([
            'data'=>$arrData
        ]);
    }

    public function record(MedicalRecord $medicalRecord){

            $arr=array();
            $arr['id']=$medicalRecord->id;
            $arr['created_at']=$medicalRecord->created_at->format("F j, Y");
            $arr['patient_id']=$medicalRecord->patient_id;
            $arr['blood_pressure']=$medicalRecord->blood_pressure;
            $arr['temperature']=$medicalRecord->temperature;
            $arr['pulse']=$medicalRecord->pulse;
            $arr['respiratory_rate']=$medicalRecord->respiratory_rate;
            $arr['height']=$medicalRecord->height;
            $arr['weight']=$medicalRecord->weight;
            $arr['symptom']=$medicalRecord->symptom;
            $arr['details']=$medicalRecord->details;
            $arr['treatment']=$medicalRecord->treatment;
            $arr['remarks']=$medicalRecord->remarks;
        
        return response()->json($arr);
    }



    /**
     * 
     * 
     * PRESCRIPTION
     * 
     * descption here....
     * 
     * 
     * 
     * 
     */

     public function prescriptionAndInventory($id){
         $patientRecord = MedicalRecord::where('medical_records.id',$id)->join('patients','medical_records.patient_id','patients.id')->first();
         return view('administrator/patient/prescriptionInventory',compact('patientRecord'));
     }
}
