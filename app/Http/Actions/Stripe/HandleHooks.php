<?php

namespace App\Http\Actions\Stripe;

use App\Services\Stripe\Payload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Laravel\Cashier\Http\Middleware\VerifyWebhookSignature;
use Lorisleiva\Actions\Action;
use App\Contracts\Http\WebHooks\Manager;

class HandleHooks extends Action
{
    /**
     * @return array
     */
    public function middleware()
    {
        return [
            VerifyWebhookSignature::class,
        ];
    }

    /**
     * @param Request $request
     * @param Manager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Manager $manager)
    {
        $payload = $this->getPayload($request);
        $class = $this->getClassByEventType($payload);

        $manager->call($request, $payload);

        if (class_exists($class)) {
            return app($class)->handle($payload);
        }

        return new Response();
    }

    /**
     * @param Request $request
     *
     * @return Payload
     */
    protected function getPayload(Request $request): Payload
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data)) {
            abort(404);
        }

        return new Payload(
            $data
        );
    }

    /**
     * @param Payload $payload
     * @return string
     */
    protected function getClassByEventType(Payload $payload): string
    {
        return 'App\Services\Stripe\Events\\' . Str::studly(str_replace('.', '_', $payload->getType()));
    }
}
