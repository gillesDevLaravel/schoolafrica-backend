<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiVerificationController extends BaseController
{
    use VerifiesEmails;

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request): JsonResponse
    {
        if ($request->route('id') != $request->user()->getKey()) {
            return $this->sendError('Invalid verification link.', [], 403);
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $this->sendResponse([], 'Email already verified.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->sendResponse([], 'Email verified successfully.');
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->sendResponse([], 'Email already verified.');
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->sendResponse([], 'Verification email sent.');
    }


}