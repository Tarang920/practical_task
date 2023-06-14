<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\GeneralResponse;
use App\Http\Resources\GeneralError;
use Illuminate\Support\Facades\Validator;
use Log,DB;
use App\Models\User;

class UserController extends Controller
{  
    public function createUser(Request $request)
    { 
        DB::beginTransaction();
        try{
            $data = $request->all();
            
            // Validation for the Create new user
            $validator = Validator::make($data,[
                'first_name' => ['required','max:255'],
                'last_name' => ['required','max:255'],
                'DOB' => ['required'],
                'gender' => ['required',]
            ]);

            if($validator->fails())
            {
                return new GeneralError(['message' => $validator->messages(),'toast' => true]);
            }else{
                $newUser = User::create($data);
                DB::commit();
                return new GeneralResponse(['data'=> $newUser,'message' => 'New User add successfully', 'toast' => true]);
            }            
        }catch(\Exception $e){
            \Log::info('Message:: '.$e->getMessage().' line:: '.$e->getLine().' Code:: '.$e->getCode().' file:: '.$e->getFile());
            DB::rollback();
            return redirect()->back()->withErrors(['msg' => 'Something Went Wrong!']);
        }
    }

    public function getUserDetail(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,['id'=>'required|exists:users,id']);

        if($validator->fails())
        {
            return new GeneralError(['message' => $validator->messages(),'toast' => true]);
        }else{
            $userDetail = User::where('id',$data['id'])->get();
            return new GeneralResponse(['data'=> $userDetail,'message' => 'User Detail Fetch successfully', 'toast' => true]);
        }
    }

    public function editUserDetail(Request $request, $id)
    {
        $requestData = $request->all();
        \Log::info($requestData);
        $data = User::findOrFail($id);

        if(empty($data))
        {
            return new GeneralError(['message' => 'Opps Data not Found :(','toast' => true]);
        }else{
            $updateUser = User::where('id',$data->id)->update($requestData);

            // Query for after updating the value to retrive updated record for append in response
            $latestUserDetails = User::where('id',$data['id'])->get();

            return new GeneralResponse(['data'=> $latestUserDetails,'message' => 'User Detail Updated successfully', 'toast' => true]);
        }
    }

    public function deleteUser($id)
    {
        // $data = $request->all();

        // $validator = Validator::make($data,['id'=>'required|exists:users,id']);

        $data = User::findOrFail($id);

        if(empty($data))
        {
            return new GeneralError(['message' => 'Opps Data is not found','toast' => true]);
        }else{
            $deleteUser = User::find($data['id']);
            $deleteUser->delete();
            return new GeneralResponse(['data' => $deleteUser,'message' => 'User Deleted Successfully']);

        }
    }

    public function allUserList()
    {
        $usersList = User::all();
        return new GeneralResponse(['data' => $usersList,'message'=>'User List Fetch Successfully']);
    }
}
