<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInquiry;
use App\Mail\LeadSubmissionMail;
use Illuminate\Support\Facades\Mail;

use App\Services\ConstantReachApiService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Throwable;

class ContactController extends Controller
{


    public function captcha(ConstantReachApiService $api)
    {
        try {
            $response = $api->getCaptcha();

            return response()->json(
                $response->json() ?? [
                    'success' => false,
                    'message' => 'Unable to load CAPTCHA.'
                ],
                $response->status()
            );

        } catch (Throwable $e) {

            Log::error('Remote CAPTCHA API error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Unable to connect to CAPTCHA service.'
            ], 502);
        }
    }

    public function store(Request $request, ConstantReachApiService $api)
{
    $expectedAnswer = session('captcha_num1', 0)
                    + session('captcha_num2', 0);

    // 1. Validate form fields and existing session CAPTCHA
    $validatedData = $request->validate([
        'first_name'          => 'required|string|max:50',
        'last_name'           => 'required|string|max:50',
        'email'               => 'required|email|max:100',
        'phone'               => 'required|string|max:20',
        'address'             => 'required|string|max:255',
        'city'                => 'required|string|max:100',
        'state'               => 'required|string|max:100',
        'zip'                 => 'required|string|max:20',
        'country'             => 'required|string|max:100',
        'company'             => 'nullable|string|max:100',
        'products_interested' => 'required|string|max:255',
        'application'         => 'required|string',
        'final_application'   => 'required|string|max:1000',
        'captcha'             => [
            'required',
            'integer',
            function ($attribute, $value, $fail) use ($expectedAnswer) {
                if ((int) $value !== $expectedAnswer) {
                    $fail('The security check equation solution typed was incorrect.');
                }
            },
        ],
    ]);

    // 2. Remove CAPTCHA before forwarding data
    unset($validatedData['captcha']);

    try {

        // 3. Submit enquiry to constantemails.com
        $response = $api->submitEnquiry($validatedData);

        // 4. Handle API failure
        if (!$response->successful()) {

            return response()->json([
                'success' => false,
                'message' => $response->json('message')
                    ?? 'Unable to submit your enquiry. Please try again.'
            ], 502);
        }

        // 5. Refresh existing session CAPTCHA
        session()->forget(['captcha_num1', 'captcha_num2']);

        session([
            'captcha_num1' => rand(2, 9),
            'captcha_num2' => rand(1, 9)
        ]);

        // 6. Return successful JSON response
        return response()->json([
            'success' => true,
            'message' => 'Information recorded successfully!'
        ], 200);

    } catch (\Throwable $e) {

        \Log::error('Contact enquiry submission failed: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Unable to submit your enquiry. Please try again later.'
        ], 500);
    }
}



    /*public function show()
    {
        if (!session()->has('captcha_num1')) {
            session(['captcha_num1' => rand(2, 9), 'captcha_num2' => rand(1, 9)]);
        }
        return view('contact');
    }

    public function submit(Request $request)
    {
        $expectedAnswer = session('captcha_num1', 0) + session('captcha_num2', 0);

        // 1. Enforce validation across all entry columns
        $validatedData = $request->validate([
            'first_name'          => 'required|string|max:50',
            'last_name'           => 'required|string|max:50',
            'email'               => 'required|email|max:100',
            'phone'               => 'required|string|max:20',
            'address'             => 'required|string|max:255',
            'city'                => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'zip'                 => 'required|string|max:20',
            'country'             => 'required|string|max:100',
            'company'             => 'nullable|string|max:100',
            'products_interested' => 'required|string|max:255',
            'application'         => 'required|string',
            'final_application'   => 'required|string|max:1000',
            'captcha'             => [
                'required', 'integer',
                function ($attribute, $value, $fail) use ($expectedAnswer) {
                    if ((int)$value !== $expectedAnswer) {
                        $fail('The security check equation solution typed was incorrect.');
                    }
                },
            ],
        ]);

        // 2. Persist record cleanly to your database table storage
        $inquiry = ContactInquiry::create($validatedData);

        // 3. Dispatch data payload processing alerts to management destinations
        Mail::to('gurpalsingh@jwhglobal.com')->send(new LeadSubmissionMail($validatedData));

        // 4. Recycle mathematical verification security variables
        session(['captcha_num1' => rand(2, 9), 'captcha_num2' => rand(1, 9)]);

        return redirect()->back()->with('success', 'Information recorded and mail dispatched successfully!');
    }*/

    /**
     * Renders the frontend interface and safely manages security values.
     */
    public function show()
    {
        // FIX: If the user is redirected back due to validation errors,
        // DO NOT overwrite the numbers. Keep them so the user's input matches.
        if (!old('_token') || !session()->has('captcha_num1')) {
            session([
                'captcha_num1' => rand(2, 9),
                'captcha_num2' => rand(1, 9)
            ]);
        }
        //echo "1";print_r(session);die;
        return view('contact');
    }

    /**
     * Standardized form handling with validation arrays for every field.
     */
    public function submit(Request $request)
    {
        $expectedAnswer = session('captcha_num1', 0) + session('captcha_num2', 0);
        //echo "expected-".$expectedAnswer.'--';
        // 1. Enforce strict validation rules across all entry fields
        $validatedData = $request->validate([
            'first_name'          => 'required|string|max:50',
            'last_name'           => 'required|string|max:50',
            'email'               => 'required|email|max:100',
            'phone'               => 'required|string|max:20',
            'address'             => 'required|string|max:255',
            'city'                => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'zip'                 => 'required|string|max:20',
            'country'             => 'required|string|max:100',
            'company'             => 'nullable|string|max:100',
            'products_interested' => 'required|string|max:255',
            'application'         => 'required|string',
            'final_application'   => 'required|string|max:1000',
            'captcha'             => [
                'required', 'integer',
                function ($attribute, $value, $fail) use ($expectedAnswer) {
                    //print_r($value);die;
                    //echo 'attr-'.$attribute.'-value-'.$value.'-fail-'.$fail;die;
                    if ((int)$value !== $expectedAnswer) {
                        $fail('The security check equation solution typed was incorrect.');
                    }
                },
            ],
        ]);

        // 2. Persist record cleanly to your database table storage
        ContactInquiry::create($validatedData);

        // 3. Dispatch processing data alerts to management destinations
        Mail::to('gurpalsingh@jwhglobal.com')->send(new LeadSubmissionMail($validatedData));

        // 4. Submission succeeded! Now clear old numbers and set new ones for next time
        session()->forget(['captcha_num1', 'captcha_num2']);
        session([
            'captcha_num1' => rand(2, 9),
            'captcha_num2' => rand(1, 9)
        ]);

        return redirect()->back()->with('success', 'Information recorded and mail dispatched successfully!');
    }
}
