<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;
use Session;
use Illuminate\Support\Facades\Http;


class CallingController extends Controller
{
    public function index()
    {
    }

    
    
    
    public function initiateCall(Request $request)
    {
        $phoneNumber = $request->phone_number;

        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);

        $fromNumber = getenv("TWILIO_PHONE_NUMBER");

        try {
            $call = $twilio->calls
                ->create($phoneNumber, $fromNumber, ["url" => "http://demo.twilio.com/docs/voice.xml"]
                );

                return response()->json(['message' => 'Call initiated successfully', 'response' => $call->sid]);
                } catch (\Throwable $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }



    public function handleGather(Request $request)
    {
        // Retrieve the call SID from the POST data
        $callSid = $request->input('CallSid');
        
        // Retrieve the call start time from the POST data
        $callStartTime = $request->input('StartTime');
        
        // Calculate the call end time and duration
        $callEndTime = now();
        $callDuration = $callEndTime->diffInSeconds($callStartTime);

        // Update the call status to "completed"
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);

        try {
            $call = $twilio->calls($callSid)->update([
                'status' => 'completed'
            ]);


            // Return the call details as JSON
            return response()->json([
                'CallSid' => $callSid,
                'StartTime' => $callStartTime,
                'EndTime' => $callEndTime,
                'Duration' => $callDuration
            ]);
        } catch (\Throwable $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }



    public function handleVoiceResponse()
    {
        $response = new VoiceResponse();
        $response->say("Hello! This is a call from your company. We're excited to discuss our products with you.");
        $response->gather([
            'action' => route('calling.handle-gather'), // URL to handle user input
            'input' => 'dtmf',
            'method' => 'POST'
        ]);

        return $response;
    }



    public function endCall(Request $request)
{
    $callSid = $request->input('callSid');
    
    // Retrieve the call start time from the database or wherever it's stored
    $callStartTime = $request->input('StartTime'); // Retrieve the start time for the given callSid

    // Calculate the call end time and duration
    $callEndTime = now();
    $callDuration = $callEndTime->diffInSeconds($callStartTime);

    $sid = getenv("TWILIO_SID");
    $token = getenv("TWILIO_AUTH_TOKEN");
    $twilio = new Client($sid, $token);

    try {
        $call = $twilio->calls($callSid)->update([
            'status' => 'completed'
        ]);

        return response()->json([
            'message' => 'Call ended successfully',
            'StartTime' => $callStartTime,
            'EndTime' => $callEndTime,
            'Duration' => $callDuration
        ]);
    } catch (\Throwable $ex) {
        return response()->json(['error' => $ex->getMessage()], 500);
    }
}


public function getCallLogs()
{
    $accountSid = getenv("TWILIO_SID");
    $authToken = getenv("TWILIO_AUTH_TOKEN");

    $response = Http::withBasicAuth($accountSid, $authToken)
        ->get("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Calls.json");

    $callLogs = $response->json()['calls'] ?? [];

    $formattedLogs = [];

    foreach ($callLogs as $call) {
        $formattedLogs[] = [
            'startTime' => $call['start_time'],
            'endTime' => $call['end_time'],
            'duration' => $call['duration'],
            'callStatus' => $call['status'],
            'fromNumber' => $call['from'],
            'toNumber' => $call['to'],
            'hungUpBy' => $call['answered_by']
        ];
    }

    return response()->json($formattedLogs);
}


}

