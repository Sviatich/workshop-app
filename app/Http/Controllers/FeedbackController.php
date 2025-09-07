<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendFeedbackRequest;
use App\Mail\FeedbackMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    /**
     * Handle contact/feedback form submission and send email.
     */
    public function send(SendFeedbackRequest $request)
    {
        $data = $request->validated();

        $to = 'workshop@mp.market';

        $mailable = new FeedbackMessage(
            fullName: $data['full_name'] ?? null,
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? null,
            subjectLine: $data['topic'] ?? ($data['subject'] ?? null),
            message: $data['message'] ?? null,
            page: $data['page'] ?? $request->headers->get('referer')
        );

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $mailable->attach($file->getRealPath(), [
                'as' => $file->getClientOriginalName(),
                'mime' => $file->getClientMimeType(),
            ]);
        }

        Mail::to($to)->send($mailable);

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Спасибо! Ваше сообщение отправлено.',
            ]);
        }

        return back()->with('status', 'Спасибо! Ваше сообщение отправлено.');
    }
}
