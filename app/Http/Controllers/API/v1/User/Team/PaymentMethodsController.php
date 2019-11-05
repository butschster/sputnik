<?php

namespace App\Http\Controllers\API\v1\User\Team;

use App\Http\Controllers\API\Controller;
use App\Models\User\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Cashier\PaymentMethod;

class PaymentMethodsController extends Controller
{
    /**
     * @param Team $team
     * @return \Illuminate\Support\Collection|\Laravel\Cashier\PaymentMethod[]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function paymentMethods(Team $team)
    {
        $this->authorize('subscribe', $team);

        $team->createOrGetStripeCustomer();

        return $team->paymentMethods()->map(function (PaymentMethod $method) {
            return [
                'id' => $method->id,
                'card' => [
                    'brand', $method->card->brand,
                    'exp_month' => $method->card->exp_month,
                    'exp_year' => $method->card->exp_year,
                    'last4' => $method->card->last4,
                ],
                'name' => $method->billing_details->name ?? 'unknown',
                'created_at' => Carbon::createFromTimestamp($method->created)
            ];
        });
    }

    /**
     * @param Team $team
     * @return \Stripe\SetupIntent
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function createIntenttion(Team $team)
    {
        $this->authorize('subscribe', $team);

        return $team->createSetupIntent()->client_secret;
    }

    /**
     * @param Request $request
     * @param Team $team
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Team $team)
    {
        $this->authorize('subscribe', $team);

        $this->validate($request, [
            'payment_method' => 'required|string'
        ]);

        $team->updateDefaultPaymentMethod($request->payment_method);

        return $this->responseOk();
    }

    /**
     * @param Team $team
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Team $team, string $id)
    {
        $this->authorize('subscribe', $team);

        $team->removePaymentMethod($id);

        return $this->responseDeleted();
    }
}