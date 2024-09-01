<?php

namespace Xypp\MoreBBCode\Helper;
use Flarum\Settings\SettingsRepositoryInterface;
use Xypp\MoreBBCode\Tags\Cloud;

class FunctionHelper
{
    protected SettingsRepositoryInterface $settings;
    protected array $disable = [];
    protected array $cloudConfig = [];
    public function __construct(SettingsRepositoryInterface $settingsRepositoryInterface)
    {
        $this->settings = $settingsRepositoryInterface;
        $this->disable = json_decode($this->settings->get("xypp-more-bbcode.disable") ?: "{}", true);
        if (!$this->disable)
            $this->disable = [];
        $this->cloudConfig = json_decode($this->settings->get("xypp-more-bbcode.cloud") ?: Cloud::$DEFAULT_VALUE, true);
    }

    public function isEnable(string $key)
    {
        if (!isset($this->disable[$key]))
            return true;
        if (!$this->disable[$key])
            return true;
        return false;
    }

    public function getCloudConfig(): array
    {
        return $this->cloudConfig;
    }
    public function getDisableConfig(): array
    {
        return $this->disable;
    }
}