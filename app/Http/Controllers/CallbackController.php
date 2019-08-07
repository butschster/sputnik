<?php

namespace App\Http\Controllers;

use App\Contracts\Request\RequestSignatureHandler;
use App\Http\Actions\Contracts\Manager;
use App\Models\CallbackLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

class CallbackController extends Controller
{
    /**
     * @var RequestSignatureHandler
     */
    protected $signatureHandler;

    /**
     * @param RequestSignatureHandler $signatureHandler
     */
    public function __construct(RequestSignatureHandler $signatureHandler)
    {
        $this->signatureHandler = $signatureHandler;
    }

    /**
     * @param Request $request
     * @param Manager $manager
     *
     * @return array|mixed
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Routing\Exceptions\InvalidSignatureException
     */
    public function __invoke(Request $request, Manager $manager)
    {
        $this->validate($request, [
            'action' => 'required|string',
            'signature' => 'required'
        ]);

        $this->checkValidSignature($request);
        $this->logRequest($request);

        $response = $manager->runAction($request->action, $request->all());

        if ($response instanceof Response) {
            return $response;
        }

        return ['status' => 'ok'];
    }

    /**
     * Check signature fro incoming request
     *
     * @param Request $request
     */
    protected function checkValidSignature(Request $request): void
    {
        if (!$this->signatureHandler->validate($request->signature, $request->only('action'), $request->expires)) {
            throw new InvalidSignatureException;
        }
    }

    /**
     * Log incoming request
     *
     * @param Request $request
     */
    protected function logRequest(Request $request): void
    {
        CallbackLog::create([
            'source' => $request->ip(),
            'data' => $request->all(),
        ]);
    }
}
