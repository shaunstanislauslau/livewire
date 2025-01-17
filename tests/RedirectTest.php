<?php

namespace Tests;

use Livewire\Component;
use Livewire\LivewireManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

class RedirectTest extends TestCase
{
    /** @test */
    function standard_redirect()
    {
        $component = app(LivewireManager::class)->test(TriggersRedirectStub::class);

        $component->runAction('triggerRedirect');

        $this->assertEquals('/local', $component->redirectTo);
    }

    /** @test */
    function redirect_helper()
    {
        $component = app(LivewireManager::class)->test(TriggersRedirectStub::class);

        $component->runAction('triggerRedirectHelper');

        $this->assertEquals(url('foo'), $component->redirectTo);
    }

    /** @test */
    function redirect_facade_with_to_method()
    {
        $component = app(LivewireManager::class)->test(TriggersRedirectStub::class);

        $component->runAction('triggerRedirectFacadeUsingTo');

        $this->assertEquals(url('foo'), $component->redirectTo);
    }

    /** @test */
    function redirect_facade_with_route_method()
    {
        $this->registerNamedRoute();

        $component = app(LivewireManager::class)->test(TriggersRedirectStub::class);

        $component->runAction('triggerRedirectFacadeUsingRoute');

        $this->assertEquals(route('foo'), $component->redirectTo);
    }

    /** @test */
    function redirect_helper_with_route_method()
    {
        $this->registerNamedRoute();

        $component = app(LivewireManager::class)->test(TriggersRedirectStub::class);

        $component->runAction('triggerRedirectHelperUsingRoute');

        $this->assertEquals(route('foo'), $component->redirectTo);
    }

    protected function registerNamedRoute()
    {
        Route::get('foo', function () {
            return true;
        })->name('foo');
    }
}

class TriggersRedirectStub extends Component
{
    public function triggerRedirect()
    {
        return $this->redirect('/local');
    }

    public function triggerRedirectHelper()
    {
        return redirect('foo');
    }

    public function triggerRedirectFacadeUsingTo()
    {
        return Redirect::to('foo');
    }

    public function triggerRedirectFacadeUsingRoute()
    {
        return Redirect::route('foo');
    }

    public function triggerRedirectHelperUsingRoute()
    {
        return redirect()->route('foo');
    }

    public function render()
    {
        return app('view')->make('null-view');
    }
}
