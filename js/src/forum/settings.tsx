import app from 'flarum/common/app';
import Select from 'flarum/common/components/Select';
import FieldSet from "flarum/common/components/FieldSet"
import { extend } from "flarum/common/extend";
import SettingsPage from "flarum/forum/components/SettingsPage";

function _trans(key: string, params?: any): string {
    const dat = app.translator.trans("xypp-more-bbcode.forum." + key, params);
    if (Array.isArray(dat)) return dat.join("");
    return dat;
}
export default function regSetting() {
    const SELECT_AC = {
        "all": _trans("auto-close.all"),
        "tablet": _trans("auto-close.tablet"),
        "phone": _trans("auto-close.phone"),
        "none": _trans("auto-close.none")
    }
    extend(SettingsPage.prototype, 'settingsItems', function (items) {
        const close = (app.session?.user?.preferences() || {})["xypp-bbcode-more-auto-close"] || "phone";
        items.add(
            'xypp-bbcode-more-auto-close',
            <FieldSet label={_trans("auto-close.title")} className="Settings auto-close">
                <Select
                    options={SELECT_AC}
                    value={close}
                    onchange={(value: string) => {
                        app.session.user!
                            .savePreferences({
                                "xypp-bbcode-more-auto-close": value
                            });
                    }}
                />
            </FieldSet>
        );
    })
}