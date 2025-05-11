<?php

namespace Piwind\MoreBBCode\Tags;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Filesystem\Factory;
use s9e\TextFormatter\Configurator;
use Piwind\MoreBBCode\Helper\FunctionHelper;
class Cloud
{
    public static $DEFAULT_VALUE = '{"other":{"name":"@.other","content":"@.password","image":"assets://piwind-more-bbcode/cloud/other.svg"},"github":{"name":"@.github","content":"@.version","image":"assets://piwind-more-bbcode/cloud/github.svg"},"gitee":{"name":"@.gitee","content":"@.version","image":"assets://piwind-more-bbcode/cloud/gitee.png"},"bd":{"name":"@.bd","content":"@.password","image":"assets://piwind-more-bbcode/cloud/baidu.svg"},"360":{"name":"@.360","content":"@.password","image":"assets://piwind-more-bbcode/cloud/360.svg"},"ty":{"name":"@.ty","content":"@.password","image":"assets://piwind-more-bbcode/cloud/tianyi.svg"},"ali":{"name":"@.ali","content":"@.password","image":"assets://piwind-more-bbcode/cloud/ali.png"},"ct":{"name":"@.ct","content":"@.password","image":"assets://piwind-more-bbcode/cloud/ct.svg"},"tx":{"name":"@.tx","content":"@.password","image":"assets://piwind-more-bbcode/cloud/tx.svg"},"lz":{"name":"@.lz","content":"@.password","image":"assets://piwind-more-bbcode/cloud/lz.svg"},"123":{"name":"@.123","content":"@.password","image":"assets://piwind-more-bbcode/cloud/123.png"},"kk":{"name":"@.quark","content":"@.password","image":"assets://piwind-more-bbcode/cloud/quark.png"},"google":{"name":"@.google","content":"@.password","image":"assets://piwind-more-bbcode/cloud/google.png"},"one":{"name":"@.one","content":"@.password","image":"assets://piwind-more-bbcode/cloud/onedrive.png"},"f":{"name":"@.f","content":"@.password","image":"assets://piwind-more-bbcode/cloud/f.png"},"mega":{"name":"@.mega","content":"@.password","image":"assets://piwind-more-bbcode/cloud/mega.png"},"dropbox":{"name":"@.dropbox","content":"@.password","image":"assets://piwind-more-bbcode/cloud/dropbox.png"},"mediafire":{"name":"@.mediafire","content":"@.password","image":"assets://piwind-more-bbcode/cloud/mediafire.jpg"}}';

    protected \Illuminate\Contracts\Filesystem\Cloud $assetsFilesystem;
    protected Translator $translator;
    protected FunctionHelper $functions;
    protected array $config = [];
    public function __construct(Translator $translator, Factory $filesystemFactory, FunctionHelper $functions)
    {
        $this->translator = $translator;
        $this->assetsFilesystem = $filesystemFactory->disk('flarum-assets');
        $this->config = $functions->getCloudConfig();
        $this->functions = $functions;
    }
    public function getImageUrl(string $image)
    {
        if (str_starts_with($image, "assets://")) {
            $segs = explode("/", substr($image, 9), 2);
            $baseUrl = $this->assetsFilesystem->url("extensions/" . $segs[0]);
            return $baseUrl . "/" . $segs[1];
        }
        return $image;
    }
    public function getTrans(string $value, string $pref)
    {
        if (str_starts_with($value, "@.")) {
            $value = "$pref." . substr($value, 2);
        }
        return $this->translator->trans($value);
    }
    public function __invoke(Configurator $config)
    {
        if (!$this->functions->isEnable("cloud")) {
            return;
        }
        $logoSwitch = "";
        $TipTxtSwitch = "";
        foreach ($this->config as $key => $cloud) {
            $logoSwitch .= '<xsl:if test="@type=\'' . $key . '\'"><img src="' . $this->getImageUrl($cloud['image']) . '"/></xsl:if>';
            $TipTxtSwitch .= '<xsl:if test="@type=\'' . $key . '\'"><span class="cloud-type">' . $this->getTrans($cloud['name'], "piwind-more-bbcode.forum.cloud.type") . '</span><span class="cloud_password">' . $this->getTrans($cloud['content'], "piwind-more-bbcode.forum.cloud.content") . ' {TEXT3}</span></xsl:if>';
        }

        // Cloud Box
        $config->BBCodes->addCustom(
            '[cloud type={TEXT1} title={TEXT2} url={URL}]{TEXT3}[/cloud]',
            '
        <div class="imeepo_cloud cloud_{TEXT1}">
        <div class="cloud_logo">
        ' . $logoSwitch . '
        </div>
            <div class="cloud_describe">
                <div class="cloud_title">{TEXT2}</div>
                <div class="cloud_content">
                    ' . $TipTxtSwitch . '
                </div>
            </div>
            <a class="cloud_button" href="{URL}" target="_blank" rel="noopener noreferrer">
                <i class="fa fa-download"></i>
            </a>
        </div>'
        );
    }
}