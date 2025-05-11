<?php

namespace Piwind\MoreBBCode;
use Flarum\Locale\Translator;
use Piwind\MoreBBCode\Helper\FunctionHelper;

class ForumAttributes
{
    protected FunctionHelper $functions;
    protected Translator $translator;
    public function __construct(FunctionHelper $functions, Translator $translator)
    {
        $this->functions = $functions;
        $this->translator = $translator;
    }
    public function getTrans(string $value, string $pref)
    {
        if (str_starts_with($value, "@.")) {
            $value = "$pref." . substr($value, 2);
        }
        return $this->translator->trans($value);
    }
    public function __invoke($serializer, $user, $attributes)
    {
        $attributes['bbcode-disable'] = $this->functions->getDisableConfig();
        $clouds = [];
        foreach ($this->functions->getCloudConfig() as $key => $cloud) {
            $clouds[$key] = $this->getTrans($cloud['name'], "piwind-more-bbcode.forum.cloud.type");
        }
        $attributes['bbcode-cloud'] = $clouds;
        return $attributes;
    }
}