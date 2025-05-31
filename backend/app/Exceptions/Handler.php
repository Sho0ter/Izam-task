<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
{
    if ($request->expectsJson()) {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Resource not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    if ($exception instanceof NotFoundHttpException) {
        return response()->json([
            'message' => 'Route not found'
        ], Response::HTTP_NOT_FOUND);
    }

    if ($exception instanceof AuthorizationException) {
        return response()->json([
            'message' => 'You are not authorized to perform this action'
        ], Response::HTTP_UNAUTHORIZED);
    }
    
    return parent::render($request, $exception);
}
}
