<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController
{
    public function __invoke(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('items.index');
    }
}