<?php

namespace Xypp\MoreBBCode\Service;
use Flarum\Foundation\AbstractServiceProvider;
use Xypp\MoreBBCode\Helper\FunctionHelper;

class SingletonRegistor extends AbstractServiceProvider
{

    public function register()
    {
        $this->container->singleton(FunctionHelper::class);
    }
}