<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class MemberController extends Controller
{
    public function data_member(Request $request){

        $sessionToken = session()->get('xrfTOKEN');
        $getToken = PersonalAccessToken::findToken($sessionToken);

        $member = Member::all();

        if($getToken){
            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Authorized',
                'data' => $member,
            ]);
        }

        return response()->json([
            'code' => 401,
            'status' => 'Error',
            'message' => 'Unauthorized',
        ]);
    }

    public function member_add(Request $request){
        $sessionToken = session()->get('xrfTOKEN');
        $getToken = PersonalAccessToken::findToken($sessionToken);

        if($getToken){
            $validator = Validator::make($request->all(),[
                'nip' => 'required|unique:members',
                'nama' => 'required',
                'jk' => 'required',
                'alamat' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors());
            }

            $member = Member::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'alamat' => $request->alamat,
            ]);

            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Member successfully added',
                'data' => $member,
            ]);
        }

        return response()->json([
            'code' => 401,
            'status' => 'Error',
            'message' => 'Unauthorized',
        ]);
    }

    public function member_detail(Request $request){
        $sessionToken = session()->get('xrfTOKEN');
        $getToken = PersonalAccessToken::findToken($sessionToken);

        if($getToken){
            $detailMember = Member::find($request->id);

            if(!$detailMember){
                return response()->json([
                    'code' => 500,
                    'status' => 'Error',
                    'message' => 'Data not found',
                ]);
            }

            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Data found',
                'data' => $detailMember,
            ]);
        }

        return response()->json([
            'code' => 401,
            'status' => 'Error',
            'message' => 'Unauthorized',
        ]);
    }

    public function member_update(Request $request){
        $sessionToken = session()->get('xrfTOKEN');
        $getToken = PersonalAccessToken::findToken($sessionToken);

        if($getToken){
            $validator = Validator::make($request->all(),[
                'nama' => 'required',
                'jk' => 'required',
                'alamat' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors());
            }


            Member::where('id', $request->id)
            ->update([
                'nama' => $request->nama,
                'jk' => $request->jk,
                'alamat' => $request->alamat,
            ]);

            $member = Member::find($request->id);

            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Member updated',
                'data' => $member,
            ]);
        }

        return response()->json([
            'code' => 401,
            'status' => 'Error',
            'message' => 'Unauthorized',
        ]);
    }

    public function member_delete(Request $request){
        $sessionToken = session()->get('xrfTOKEN');
        $getToken = PersonalAccessToken::findToken($sessionToken);

        if($getToken){
            $member = Member::find($request->id);

            if(!$member){
                return response()->json([
                    'code' => 500,
                    'status' => 'Error',
                    'message' => 'Data not found',        
                ]);
            }

            $member->delete();

            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Member successfully deleted',
            ]);
        }

        return response()->json([
            'code' => 401,
            'status' => 'Error',
            'message' => 'Unauthorized',
        ]);
    }
}
