<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Xypp\MoreBBCode;

use s9e\TextFormatter\Configurator;
use Flarum\Locale\Translator;

class Configure
{
    protected array $tags = [];
    public function __construct(
        Tags\Cloud $cloud,
        Tags\Container $container,
        Tags\DownwardCompatible $downwardCompatible,
        Tags\Embed $embed,
        Tags\HighlightJSFix $highlightJSFix,
        Tags\LiteYouTubeTemplate $liteYouTubeTemplate,
        Tags\Misc $misc,
        Tags\RepositoryBBCode $repositoryBBCode,
        Tags\RepositoryHtml $repositoryHtml,
        Tags\Typography $typography,
        Tags\Widget $widget,
        Tags\XXXToSee $xxxToSee
    ) {
        $this->tags = [
            $cloud,
            $container,
            $downwardCompatible,
            $embed,
            $liteYouTubeTemplate,
            $misc,
            $repositoryBBCode,
            $repositoryHtml,
            $typography,
            $widget,
            $xxxToSee,
            $highlightJSFix,
        ];
    }
    public function __invoke(Configurator $config)
    {
        foreach ($this->tags as $tag) {
            $tag($config);
        }
    }
}