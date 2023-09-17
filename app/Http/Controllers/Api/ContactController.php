<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function message(Request $request)
    {
        $data = $request->all();

        // Validtion
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'message' => 'required|string',
            'cellNumb' => 'nullable'
        ], [
            'email.required' => 'La mail è obbligatoria',
            'email.email' => 'La mail non è valida',
            'message.required' => 'Il messaggio è obbligatorio'
        ]);

        // If errors return errors 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        };

        // New mail
        $mail = new ContactMessageMail(
            sender: $data['email'],
            message: $data['message'],
            cellNumb: $data['cellNumb']
        );


        Mail::to(env('MAIL_TO_ADDRESS'))->send($mail);
        return response(null, 204);
    }
}
