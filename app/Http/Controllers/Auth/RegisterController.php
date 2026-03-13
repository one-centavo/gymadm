<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;



class RegisterController extends Controller
{

    public function __construct(protected RegistrationService $registrationService)
    {
    }

    public function index()
    {
        return view('auth.register');
    }

    public function sendOtp(SendOtpRequest $request): JsonResponse {

        $email = $request->validated()['email'];

        if($this->registrationService->isEmailAvailable($email)) {
            return response()->json([
                'message' => 'Verify your email and try again.',
                'data' => [
                    'email' => $email
                ]
            ], 422);
        }

        $this->registrationService->requestEmailVerification($email);

        $request->session()->put('email', $email);

        return redirect()->route('register.otp');
    }

    public function showOtpForm(){
        return view('register.otp');
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse {
        $email = $request->validated()['email'];
        $otp = $request->validated()['otp'];

        if(!$this->registrationService->verifyIdentity($email, $otp)){
            return response()->json([
                'message' => 'Invalid OTP code. Please try again.',
                'data' => [
                    'email' => $email
                ]
            ], 422);
        }

        $request->session()->put('email', $email);
        $request->session()->put('verified_otp', true);

        return redirect()->route('register.form');

    }

    public function showRegistrationForm(){
        return view('register.form');
    }

    public function registerMember(RegisterRequest $request): JsonResponse {
        $email = $request->session()->get('email');
        $verifiedOtp = $request->session()->get('verified_otp', false);

        if(!$email || !$verifiedOtp) {
            return response()->json([
                'message' => 'Unauthorized. Please verify your email first.',
            ], 401);
        }

        $data = $request->validated();

        $this->registrationService->registerByMember($data);


        $request->session()->forget(['email', 'verified_otp']);

        return response()->json([
            'message' => 'Registration successful. You can now log in.',
        ], 201);
    }











}
