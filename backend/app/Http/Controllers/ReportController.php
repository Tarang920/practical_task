<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Http\Resources\GeneralResponse;
use App\Http\Resources\GeneralError;
use Illuminate\Support\Facades\Validator;
use Log,DB;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->all();
            
            // Validation for the Create new user
            $validator = Validator::make($data,[
                'title' => ['required','max:255'],
                'description' => ['required'],
                'user_id' => ['required','exists:users,id'],
            ]);

            if($validator->fails())
            {
                return new GeneralError(['message' => $validator->messages(),'toast' => true]);
            }else{
                $newReport = Report::create($data);
                DB::commit();
                return new GeneralResponse(['data'=> $newReport,'message' => 'New Report add successfully', 'toast' => true]);
            }            
        }catch(\Exception $e){
            \Log::info('Message:: '.$e->getMessage().' line:: '.$e->getLine().' Code:: '.$e->getCode().' file:: '.$e->getFile());
            DB::rollback();
            return redirect()->back()->withErrors(['msg' => 'Something Went Wrong!']);
        }
    }

    public function editReportDetail(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,['id'=>'required|exists:reports,id']);

        if($validator->fails())
        {
            return new GeneralError(['message' => $validator->messages(),'toast' => true]);
        }else{
            $updateReport = Report::where('id',$data['id'])->update($data);

            // Query for after updating the value to retrive updated record for append in response
            $latestReportDetails = Report::where('id',$data['id'])->get();

            return new GeneralResponse(['data'=> $latestReportDetails,'message' => 'User Detail Updated successfully', 'toast' => true]);
        }
    }

    public function deleteReport($id)
    {   
        $data = Report::findOrFail($id);

        if(empty($data))
        {
            return new GeneralError(['message' => $validator->messages(),'toast' => true]);
        }else{
            $deleteReport = Report::find($data['id']);
            $deleteReport->delete();
            return new GeneralResponse(['data' => $deleteReport,'message' => 'Report Deleted Successfully']);

        }
    }

    public function allReportList()
    {
        $usersList = Report::with(['userDetails'])->get();
        return new GeneralResponse(['data' => $usersList,'message'=>'User List Fetch Successfully']);
    }

    public function getReportDetail(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,['id'=>'required|exists:reports,id']);

        if($validator->fails())
        {
            return new GeneralError(['message' => $validator->messages(),'toast' => true]);
        }else{
            $reportDetail = Report::where('id',$data['id'])->with(['userDetails'])->get();
            return new GeneralResponse(['data'=> $reportDetail,'message' => 'Report Detail Fetch successfully', 'toast' => true]);
        }
    }
}
