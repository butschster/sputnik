<?php

namespace Tests\Unit\Http\Actions;

use App\Events\Action\Executed;
use App\Exceptions\Actions\ActionNotFoundException;
use App\Http\Actions\Manager;
use Illuminate\Support\Facades\Event;
use Lorisleiva\Actions\Action;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    function test_the_event_should_be_dispatched()
    {
        Event::fake();

        $manager = new Manager([
            'test' => ManagerTestAction::class,
        ]);

        $manager->runAction('test');

        Event::assertDispatched(Executed::class, function ($event) {
            return $event->action instanceof ManagerTestAction;
        });
    }

    function test_throw_an_exception_if_action_not_found()
    {
        $manager = new Manager([]);

        $this->expectException(ActionNotFoundException::class);

        $manager->runAction('test');
    }

}

class ManagerTestAction extends Action
{
    public function handle()
    {
    }
}
