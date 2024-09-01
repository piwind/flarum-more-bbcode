import Modal, { IInternalModalAttrs } from "flarum/common/components/Modal";
import app from "flarum/forum/app";
import { StyleArgs } from "../helper/tagCollector";
import Select from "flarum/common/components/Select"
import { bbcode } from "../utils/styleUtil";
import Button from "flarum/common/components/Button";
function _trans(key: string, params?: any): string {
    const dat = app.translator.trans("xypp-more-bbcode.forum.alert." + key, params);
    if (Array.isArray(dat)) return dat.join("");
    return dat;
}
export default class alertPreviewModal extends Modal<{
    onsubmit: (style: Partial<StyleArgs>) => void;
    oncancel: () => void;
} & IInternalModalAttrs> {
    done: boolean = false;
    typesOpt: Record<string, string> = {};
    availableMap: Record<string, string[]> = {
        "success": ["a", "b", "c", "d"],
        "warning": ["a", "b", "c", "d"],
        "error": ["a", "b", "c", "d"],
        "notice": ["a", "b", "c", "d"],
        "basic": ["a"],
        "custom": ["a", "b"],
    };
    colorMap: Record<string, string[]> = {
        "success": ["green", "white", "green"],
        "error": ["red", "white", "red"],
        "notice": ["teal", "white", "teal"],
        "warning": ["darkorange", "white", "darkorange"],
        "custom": ["red", "white", "red"],
    };
    available: string[] = ["a", "b", "c", "d"];
    type: string = "notice";
    style: string = "a";
    public oninit(vnode: any) {
        super.oninit(vnode);
        this.typesOpt = {
            "success": _trans("type.success") + "",
            "warning": _trans("type.warning") + "",
            "error": _trans("type.error") + "",
            "notice": _trans("type.notice") + "",
            "basic": _trans("type.basic") + "",
            "custom": _trans("type.custom") + "",
        };
    }
    public className() {
        return "alertPreviewModal Modal--small";
    }
    public title() {
        return _trans("title");
    }
    content() {
        const availableDict: Record<string, string> = {};
        this.available.forEach(v => {
            availableDict[v] = v;
        });
        return <div className="Modal-body">
            <div className="Form-group">
                <label for="xypp-more-bbcode-alert-type">
                    {_trans("type.label")}
                </label>
                <Select options={this.typesOpt} value={this.type} onchange={((e: string) => {
                    this.type = e;
                    this.available = this.availableMap[e];
                }).bind(this)}></Select>
            </div>
            <div className="Form-group">
                <label for="xypp-more-bbcode-alert-type">
                    {_trans("style")}
                </label>
                <Select options={availableDict} value={this.style} onchange={((e: string) => {
                    this.style = e;
                }).bind(this)}></Select>
            </div>
            <div className="bbcode-alert-preview">

            </div>
            <Button className="Button Button--primary" type="submit">{_trans("insert")}</Button>
        </div>;
    }
    generateStyle(): Partial<StyleArgs> {
        const style = this.style;
        const type = this.type;
        if (this.type === "custom") {
            if (this.style === "a") {
                return bbcode(
                    `[acustom]${this.colorMap.custom.join(",")},${_trans("defaults.content", { type, style })}`
                );
            } else if (this.style === "b") {
                return bbcode(
                    `[bcustom]title=${_trans("defaults.content", { type, style })} font=${this.colorMap.custom[0]} bg=${this.colorMap.custom[1]} border=${this.colorMap.custom[2]}`
                )
            } else return {};
        }
        switch (this.style) {
            case "a": return bbcode(
                `[a${this.type}]${_trans("defaults.content", { type, style })}`
            );
            case "b": return bbcode(
                `[b${this.type}]${_trans("defaults.content", { type, style })}`
            );
            case "c": return bbcode(
                `[c${this.type}]${this.colorMap[type].join(",")},${_trans("defaults.title")},${_trans("defaults.content", { type, style })}`
            );
            case "d": return bbcode(
                `[d${this.type} title=${_trans("defaults.title")} font=${this.colorMap.custom[0]} bg=${this.colorMap.custom[1]} border=${this.colorMap.custom[2]}]${_trans("defaults.content", { type, style })}`
            );
            default:
                return {};
        }
    }
    generateBBCode(): string {
        const style = this.generateStyle();
        return (style.prefix + "") + (style.suffix || "");
    }
    onupdate(vnode: any): void {
        super.onupdate(vnode);
        //@ts-ignore
        s9e.TextFormatter.preview(
            this.generateBBCode(),
            this.$(".bbcode-alert-preview")[0]
        );
    }
    onsubmit(e: SubmitEvent): void {
        e.preventDefault();
        this.done = true;
        this.attrs.onsubmit(this.generateStyle());
        app.modal.close();
    }
    onbeforeremove(vnode: any): Promise<void> | void {
        if (this.done) return;
        this.attrs.oncancel();
    }
}