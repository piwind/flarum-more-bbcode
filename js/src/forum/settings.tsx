import app from 'flarum/common/app';
import Select from 'flarum/common/components/Select';
import FieldSet from "flarum/common/components/FieldSet"
import { extend } from "flarum/common/extend";
import SettingsPage from "flarum/forum/components/SettingsPage";
import classList from 'flarum/common/utils/classList';
import { showIf } from './utils/nodeUtil';
import { getValue } from './utils/preferenceUtil';

function _trans(key: string, params?: any): string {
    const dat = app.translator.trans("piwind-more-bbcode.forum." + key, params);
    if (Array.isArray(dat)) return dat.join("");
    return dat;
}
export default function regSetting() {
    const config: Record<string, string[]> = {
        "auto-close": ["all", "tablet", "phone", "none"],
        "pref-markdown": ["all", "collected", "none"],
        "collect-all": ["all", "tablet", "phone", "none"],
        "remove-markdown": ["all", "tablet", "phone", "none"],
        "collect-markdown": ["first", "sub", "none"],
    }
    extend(SettingsPage.prototype, 'settingsItems', function (items) {
        items.add(
            'piwind-more-bbcode', [
            <h2>{_trans("name")}</h2>,
            Object.keys(config).map((key) => {
                const opts: Record<string, string> = {};
                config[key].forEach(k => { opts[k] = _trans(`${key}.${k}`) });
                const value = getValue(key) || config[key][0];
                const fm = app.forum.attribute("piwind-more-bbcode-" + key);
                return <FieldSet label={_trans(key + ".title")} className={classList("Settings", "Settings-" + key)}>
                    <small className='setting-default-value'>{showIf(!!fm, _trans("preference-default", { "default": _trans(`${key}.${fm}`) }))}</small>
                    <Select
                        options={opts}
                        value={value}
                        onchange={(value: string) => {
                            const saveObj: Record<string, string> = {}
                            saveObj["piwind-more-bbcode-" + key] = value;
                            app.session.user!.savePreferences(saveObj);
                        }}
                    />
                </FieldSet>
            })]
        );
    })
}