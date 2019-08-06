<?php

namespace App\Http\Controllers;

use App\Http\Actions\Contracts\Manager;
use App\Models\CallbackLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class CallbackController extends Controller
{
    /**
     * @param Request $request
     * @param Manager $manager
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request, Manager $manager)
    {
        if (!$this->hasValidSignature($request)) {
            throw new InvalidSignatureException;
        }

        $this->validate($request, [
            'action' => 'required|string',
        ]);

        CallbackLog::create([
            'source' => $request->ip(),
            'data' => $request->all(),
        ]);

        $response = $manager->runAction($request->action, $request->all());

        if ($response instanceof Response) {
            return $response;
        }

        return ['status' => 'ok'];
    }

    /**
     * Determine if the given request has a valid signature.
     *
     * @param \Illuminate\Http\Request $request
     * @param bool $absolute
     * @return bool
     */
    public function hasValidSignature(Request $request)
    {
        $original = route('callback');

        $expires = $request->expires;
        $requestSignature = (string) $request->signature;

        $signature = hash_hmac('sha256', $original, config('app.key'));

        $request->offsetUnset('expires');
        $request->offsetUnset('signature');

        return hash_equals($signature, $requestSignature) &&
            !($expires && Carbon::now()->getTimestamp() > $expires);
    }
}
