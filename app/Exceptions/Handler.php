<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     * @var array
     */
    protected $dontReport = [//
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $response = parent::render($request, $exception);

        if ($request->expectsJson()) {
            if ($response instanceof RedirectResponse) {
                return $this->redirectJson($request, $response);
            }
        }

        return $response;
    }

    /**
     * Convert redirect response into a JSON response
     *
     * @param \Illuminate\Http\Request $request
     * @param RedirectResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function redirectJson($request, RedirectResponse $response)
    {
        return response()->json([
            'url' => $response->getTargetUrl(),
        ], $response->getStatusCode());
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Validation\ValidationException $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'message' => $exception->getMessage(),
            'errors' => $exception->errors(),
            'bag' => $exception->errorBag == 'default' ? null : $exception->errorBag,
        ], $exception->status);
    }

}
