<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
use Validator;
use DB;
use Auth;
use Hash;
use Cache;

class ProfileController extends Controller
{
    private $data;

    public function __construct()
    {
        $this->data['user'] = Auth::user();
        $this->data['title'] = 'Profile';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('dashboard.profile.index', $this->data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function upload(Request $request)
    {
        if($request->hasFile('file')) {

            $file = $request->file('file');

            $validator = Validator::make(
                [
                    'Avatar'    =>  $file
                ],
                [
                    'Avatar'    =>  'required|mimes:jpg,jpeg,png,gif'
                ]
            );

            if($validator->fails()) {
                return response()->json([
                    'status'    =>  0,
                    'errors'    =>  $validator->messages()
                ]);
            }


            $filename =  uniqid() . '.jpg';
            $path = public_path('uploads/profile/' . $filename);

            // $imgData = Image::make('public/foo.jpg')->iptc();

            $img = Image::make( $file->getRealPath() )->fit(128,128)->encode('jpg', 80);

            if($img->save($path)) {

                $previousAvatar = public_path('uploads/profile/'. Auth::user()->avatar);

                if(file_exists($previousAvatar) && Auth::user()->avatar != 'default-avatar.jpg') {
                    unlink($previousAvatar);
                }

                DB::table('users')
                                    ->where('id', Auth::id())
                                    ->update(['avatar' => $filename]);

                return response()->json([
                    'status'    =>  1,
                    'photo'     =>  $filename
                ]);

            } else {
                return response()->json([
                    'status'    =>  0
                ]);
            }

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $fullname = trim($request->input('fullname'));
        $address = trim($request->input('address'));
        // $email = $request->input('email');
        $contact = trim($request->input('contact'));

        if($contact == Auth::user()->contact) {
            $contactRules = '';
        } else {
            $contactRules = 'required|numeric|regex:/\d{11,13}/';
        }

        $validator = Validator::make(
            [
                'Full Name'     =>  $fullname,
                'Address'       =>  $address,
                // 'Email'         =>  $email,
                'Contact'       =>  $contact,
            ],
            [
                'Full Name'     =>  'required|regex:/^[a-z\d\-_\s]+$/i',
                'Address'       =>  'required',
                'Contact'       =>  $contactRules,
            ]
        );

        if($validator->fails() && $request->ajax()) {
            return response()->json([
                'status'    =>  0,
                'message'     =>  $this->formatValidationErrors($validator)
            ]);
        } elseif($validator->fails() && ! $request->ajax()) {
            $request->flash();
            return view('dashboard.profile.index',$this->data)->withErrors($validator);
        }else{

            User::where('id', Auth::user()->id)
                ->update([
                    'fullname'      =>  $fullname,
                    'address'       =>  $address,
                    'contact'       =>  $contact
                ]);

            return response()->json([
                'status'    =>  1
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $currentPassword = $request->input('currentPassword');
        $newPassword = $request->input('newPassword');

        $validator = Validator::make(
            [
                'Current Password'  =>  $currentPassword,
                'New Password'      =>  $newPassword
            ],
            [
                'Current Password'  =>  'required',
                'New Password'      =>  'required'
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  $this->formatValidationErrors($validator)
            ]);
        } else {

            if(Hash::check($currentPassword,Auth::user()->password)) {
                User::where('id', Auth::user()->id)->update(['password' => Hash::make($newPassword)]);
                return response()->json([
                    'status'    =>  1
                ]);
            } else {
                return response()->json([
                    'status'    =>  0,
                    'message'   =>  ['Your previous password did not match']
                ]);
            }

            // if()

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
