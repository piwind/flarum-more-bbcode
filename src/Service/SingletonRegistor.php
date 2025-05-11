<?php

namespace Piwind\MoreBBCode\Service;
use Flarum\Foundation\AbstractServiceProvider;
use Piwind\MoreBBCode\Helper\FunctionHelper;

class SingletonRegistor extends AbstractServiceProvider
{

    public function register()
    {
        $this->container->singleton(FunctionHelper::class);
    }
}