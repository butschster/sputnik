<?php

namespace App\Http\Controllers;

use App\Http\Actions\Contracts\Manager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $this->validate($request, [
            'action' => 'required',
        ]);

        $response = $manager->runAction($request->action, $request->all());

        if ($response instanceof Response) {
            return $response;
        }

        return ['status' => 'ok'];
    }
}
