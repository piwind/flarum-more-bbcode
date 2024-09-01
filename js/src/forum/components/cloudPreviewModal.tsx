import Modal, { IInternalModalAttrs } from "flarum/common/components/Modal";
import app from "flarum/forum/app";
import { StyleArgs } from "../helper/tagCollector";
import Select from "flarum/common/components/Select"
import { bbcode } from "../utils/styleUtil";
import Button from "flarum/common/components/Button";
import common from "../utils/commonReplace";
function _trans(key: string, params?: any): string {
    const dat = app.translator.trans("xypp-more-bbcode.forum.cloud." + key, params);
    if (Array.isArray(dat)) return dat.join("");
    return dat;
}
export default class cloudPreviewModal extends Modal<{
    onsubmit: (style: Partial<StyleArgs>) => void;
    oncancel: () => void;
} & IInternalModalAttrs> {
    done: boolean = false;
    opts: Record<string, string> = {};
    type: string = "other";
    public oninit(vnode: any) {
        super.oninit(vnode);
        this.opts = app.forum.attribute("bbcode-cloud");
    }
    public className() {
        return "alertPreviewModal Modal--small";
    }
    public title() {
        return _trans("title");
    }
    content() {
        return <div className="Modal-body">
            <div className="Form-group">
                <label for="xypp-more-bbcode-cloud-type">
                    {_trans("type.label")}
                </label>
                <Select options={this.opts} value={this.type} onchange={((e: string) => {
                    this.type = e;
                }).bind(this)}></Select>
            </div>
            <div className="bbcode-cloud-preview">

            </div>
            <Button className="Button Button--primary" type="submit">{_trans("insert")}</Button>
        </div>;
    }
    generateStyle(): Partial<StyleArgs> {
        return bbcode(`[cloud type="${this.type}" title="${common("title")}" url="${common("url")}"]${_trans("content.defaults")}`);
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
            this.$(".bbcode-cloud-preview")[0]
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