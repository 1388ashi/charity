<?php


namespace Modules\Core\Classes;


use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\View as ViewContract;
use Illuminate\Container\Container;

class Views extends \CyrildeWit\EloquentViewable\Views
{
    protected function createView(): ViewContract
    {
        $view = Container::getInstance()->make(ViewContract::class);

        return $view->create([
            'viewable_id' => $this->viewable->getKey(),
            'viewable_type' => $this->viewable->getMorphClass(),
            'visitor' => $this->visitor->id(),
            'ip' => $this->visitor->ip(),
            'collection' => $this->collection,
            'viewed_at' => Carbon::now(),
        ]);
    }
}
