import ExtensionPage from "flarum/admin/components/ExtensionPage";
import app from 'flarum/admin/app';
import Button from "flarum/common/components/Button";
import LoadingIndicator from "flarum/common/components/LoadingIndicator";
import Checkbox from "flarum/common/components/Checkbox";
import Stream from 'flarum/common/utils/Stream';
import Alert from "flarum/common/components/Alert";
const FUNCTIONS = new Set(["cloud", "detail", "tabs", "size", "color", "audio", "download", "clip", "gdoc", "litedown", "table", "spoiler", "bold", "italic", "underline", "strike_through", "url", "image", "email", "code", "quote", "list-ul", "list-ol", "color", "size", "align-left", "align-right", "align-center", "align", "align-center", "align-left", "align-right", "justify", "background", "subscript", "superscript", "strike-through", "underline", "horizontal-line", "acronym", "iframe", "padding-left", "padding-right", "image-right", "image-center", "image-right", "dropcap", "indent", "progress", "alert", "reply", "login", "login", "like"]);

function _trans(key: string, params?: any): string {
    const dat = app.translator.trans("xypp-more-bbcode.admin." + key, params);
    if (Array.isArray(dat)) return dat.join("");
    return dat;
}

export default class adminPage extends ExtensionPage {
    disables: Record<string, boolean> = {};
    cloud: { name: string, image: string, content: string, key: string }[] = [];
    setting_disables: Stream;
    setting_cloud: Stream;
    saving: boolean = false;
    oninit(vnode: any): void {
        super.oninit(vnode);
        this.setting_disables = this.setting("xypp-more-bbcode.disable");
        this.setting_cloud = this.setting("xypp-more-bbcode.cloud");
        this.disables = JSON.parse(this.setting_disables() || "{}");
        const cloudTmp = JSON.parse(this.setting_cloud());
        Object.keys(cloudTmp).forEach(key => {
            this.cloud.push({
                ...cloudTmp[key], key
            });
        });
    }
    oncreate(vnode: any): void {
        super.oncreate(vnode);
    }
    content(vnode: any) {
        return <div className="xypp-bbcode-more-adminPage-container container">
            <Alert dismissible={false} type="warning">
                {_trans("settings.tip")}
            </Alert>
            <h2>{_trans("settings.misc.title")}</h2>
            {
                this.buildSettingComponent({
                    setting: 'xypp-more-bbcode.remove_markdown',
                    label: _trans("settings.misc.replace_md.title"),
                    type: 'select',
                    options: {
                        none: _trans("settings.misc.replace_md.none"),
                        phone: _trans("settings.misc.replace_md.phone"),
                        tablet: _trans("settings.misc.replace_md.tablet"),
                        all: _trans("settings.misc.replace_md.all")
                    }
                })
            }
            {
                this.buildSettingComponent({
                    setting: 'xypp-more-bbcode.collect_all',
                    label: _trans("settings.misc.collect_all.title"),
                    type: 'select',
                    options: {
                        none: _trans("settings.misc.collect_all.none"),
                        phone: _trans("settings.misc.collect_all.phone"),
                        tablet: _trans("settings.misc.collect_all.tablet"),
                        all: _trans("settings.misc.collect_all.all")
                    }
                })
            }
            <h2>{_trans("settings.functions.title")}</h2>
            <div className="xypp-bbcode-more-function">
                {this.getFunctionCheckboxes()}
            </div>
            <h2>{_trans("settings.cloud.title")}</h2>
            <table className="Table Table--full">
                <thead>
                    <tr>
                        <th>{_trans('settings.cloud.key')}</th>
                        <th>{_trans('settings.cloud.name')}</th>
                        <th>{_trans('settings.cloud.image')}</th>
                        <th>{_trans('settings.cloud.content')}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {this.cloud.map((item, index) => {
                        return <tr key={index}>
                            <td><input className="FormControl" type="text" value={item.key} onchange={((e: InputEvent) => {
                                this.cloud[index].key = (e.target as HTMLInputElement).value;
                            }).bind(this)} /></td>
                            <td><input className="FormControl" type="text" value={item.name} onchange={((e: InputEvent) => {
                                this.cloud[index].name = (e.target as HTMLInputElement).value;
                            }).bind(this)} /></td>
                            <td><input className="FormControl" type="text" value={item.image} onchange={((e: InputEvent) => {
                                this.cloud[index].image = (e.target as HTMLInputElement).value;
                            }).bind(this)} /></td>
                            <td><input className="FormControl" type="text" value={item.content} onchange={((e: InputEvent) => {
                                this.cloud[index].content = (e.target as HTMLInputElement).value;
                            }).bind(this)} /></td>
                            <td>
                                <Button onclick={(() => {
                                    if (!confirm(_trans("settings.cloud.confirm")))
                                        this.cloud.splice(index, 1);
                                    m.redraw();
                                }).bind(this)}>
                                    <i className="fas fa-trash"></i>
                                </Button>
                            </td>
                        </tr>
                    })}
                    <tr><td><Button className="Button Button--secondary" onclick={this.addRow.bind(this)}>{_trans("settings.cloud.add")}</Button></td></tr>
                </tbody>
            </table>
            <Button className="Button Button--primary" onclick={this.save.bind(this)} disabled={this.saving} loading={this.saving}>{_trans("settings.save")}</Button>
        </div>
    }
    getFunctionCheckboxes() {
        const ret: Checkbox[] = []
        FUNCTIONS.forEach(func => {
            ret.push(Checkbox.component({
                onchange: this.changeStateCbMaker(func),
                state: !(this.disables[func]),
            }, func));
        })
        return ret;
    }
    changeStateCbMaker(func: string) {
        return ((e: boolean) => {
            if (!e) this.disables[func] = true;
            else if (this.disables[func]) delete this.disables[func];
        }).bind(this);
    }
    addRow() {
        this.cloud.push({
            name: "", image: "", key: "new", content: ""
        })
    }
    save(e: any) {
        this.saving = true;
        m.redraw();
        const tmpCloud: Record<string, any> = {};
        this.cloud.forEach(item => {
            tmpCloud[item.key] = {
                name: item.name,
                image: item.image,
                content: item.content
            }
        });
        this.setting_cloud(JSON.stringify(tmpCloud));
        this.setting_disables(JSON.stringify(this.disables));
        this.saveSettings(e).then(() => {
            this.saving = false;
            m.redraw();
        });
    }
}