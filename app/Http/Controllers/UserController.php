<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller {
    public function userRegistration( Request $request ) {
        try {
            $request->validate( [
                'firstName' => 'required|string|max:50',
                'lastName'  => 'required|string|max:50',
                'email'     => 'required|string|email|unique:users,email|max:50',
                'mobile'    => 'required|string|max:50',
                'password'  => 'required|string|min:6',
            ] );

            User::create( [
                'firstName' => $request->input( 'firstName' ),
                'lastName'  => $request->input( 'lastName' ),
                'email'     => $request->input( 'email' ),
                'mobile'    => $request->input( 'mobile' ),
                'password'  => Hash::make( $request->input( 'password' ) ),
            ] );

            $user = User::where( 'email', '=', $request->input( 'email' ) )->first();

            // for login
            $token = $user->createToken( 'authToken' )->plainTextToken;

            return response()->json( [
                'status'  => 'success',
                'message' => 'User Registration Successful',
                'token'   => $token,
            ] );

        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ] );
        }
    }

    public function userLogin( Request $request ) {
        try {
            $request->validate( [
                'email'    => 'required|string|email|max:50',
                'password' => 'required|string|min:6',
            ] );

            $user = User::where( 'email', '=', $request->input( 'email' ) )->first();

            if ( !$user || !Hash::check( $request->input( 'password' ), $user->password ) ) {
                return response()->json( [
                    'status'  => 'failed',
                    'message' => 'Invalid User',
                ] );
            }

            $token = $user->createToken( 'authToken' )->plainTextToken;

            return response()->json( [
                'status'  => 'success',
                'message' => 'Login Successful',
                'token'   => $token,
            ] );

        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ] );
        }
    }

    public function userLogout( Request $request ) {
        $request->user()->tokens()->delete();
        return redirect( '/userLogin' );
    }

    public function sendOtp( Request $request ) {
        try {
            $request->validate( [
                'email' => 'required|email',
            ] );

            $email = $request->input( 'email' );
            $otp   = rand( 1000, 9999 );
            $count = User::where( 'email', '=', $email )->count();

            if ( $count == 1 ) {
                // otp
                Mail::to( $email )->send( new OtpMail( $otp ) );

                // otp update
                User::where( 'email', '=', $email )->update( ['otp' => $otp] );

                return response()->json( [
                    "status"  => "success",
                    "message" => "4 digits otp code has been send to your email.",
                ] );
            } else {
                return response()->json( [
                    "status"  => "failed",
                    "message" => "Invalid Email",
                ] );
            }

        } catch ( Exception $e ) {
            return response()->json( [
                "status"  => "failed",
                "message" => $e->getMessage(),
            ] );
        }
    }

    public function verifyOtp( Request $request ) {
        try {
            $request->validate( [
                'email' => 'required|string|email|max:50',
                'otp'   => 'required|string|min:4',
            ] );

            $email = $request->input( 'email' );
            $otp   = $request->input( 'otp' );

            $user = User::where( 'email', '=', $email )->where( 'otp', '=', $otp )->first();

            if ( !$user ) {
                return response()->json( [
                    'status'  => 'failed',
                    'message' => 'Invalid OTP',
                ] );
            }

            User::where( 'email', '=', $email )->update( ['otp' => '0'] );

            $token = $user->createToken( 'authToken' )->plainTextToken;

            return response()->json( [
                'status'  => 'success',
                'message' => 'OTP Verification Successful',
                'token'   => $token,
            ] );

        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ] );
        }
    }

    public function passwordReset( Request $request ) {
        try {
            $request->validate( [
                'password' => 'required|string|min:6',
            ] );

            $id       = Auth::id();
            $password = $request->input( 'password' );
            User::where( 'id', '=', $id )->update( ['password' => Hash::make( $password )] );

            return response()->json( [
                'status'  => 'success',
                'message' => 'Password Reset Successful',
            ] );

        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ] );
        }
    }

    public function userProfile( Request $request ) {
        return Auth::user();
    }

    public function updateProfile( Request $request ) {
        try {
            $request->validate( [
                'firstName' => 'required|string|max:50',
                'lastName'  => 'required|string|max:50',
                'mobile'    => 'required|string|max:50',
                'password'  => 'nullable|string|min:6',
            ] );

            User::where( 'id', '=', Auth::id() )->update( [
                'firstName' => $request->input( 'firstName' ),
                'lastName'  => $request->input( 'lastName' ),
                'mobile'    => $request->input( 'mobile' ),
                'password'  => Hash::make( $request->input( 'password' ) ),
            ] );

            return response()->json( [
                'status'  => 'success',
                'message' => 'Profile Update Successful',
            ] );

        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'fail',
                'message' => $e->getMessage(),
            ] );
        }
    }
}