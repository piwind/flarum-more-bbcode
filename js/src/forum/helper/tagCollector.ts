import { NestedStringArray } from "@askvortsov/rich-icu-message-formatter";
import app from "flarum/forum/app";
import ItemList from "flarum/common/utils/ItemList";
import Component from "flarum/common/Component";
import Mithril from "mithril";

export interface StyleArgs {
    prefix: string;
    suffix: string;
    blockPrefix: string;
    blockSuffix: string;
    multiline: boolean;
    replaceNext: string;
    prefixSpace: boolean;
    scanFor: string;
    surroundWithNewlines: boolean;
    orderedList: boolean;
    unorderedList: boolean;
    trimFirst: boolean;
}
export type TooltipKeyType = string | {
    key: string,
    params: any
};
export type IconType = string | false | {
    component: any,
    attrs: any
} | (() => Mithril.ClassComponent | JSX.Element);
export type StyleType = Partial<StyleArgs> | (() => Partial<StyleArgs>) | (() => Promise<Partial<StyleArgs>>) | (() => void);

//Tags
export type TagButton = {
    type: "button",
    icon: IconType,
    tooltip: NestedStringArray,
    name: string,
    style: StyleType
}
export type TagCollected = {
    type: "collect",
    name: string,
    component: Mithril.ClassComponent | JSX.Element
}
export type TagButtonGroup = {
    type: "group",
    icon: IconType,
    tooltip: NestedStringArray,
    tags: TagCollector,
    name: string,
    rows: number
}
export type TagSpace = {
    type: "space"
}
export type Tags = TagButton | TagButtonGroup | TagSpace | TagCollected;
export default class TagCollector {
    public tags: ItemList<(Tags)> = new ItemList();
    spaceKey = 0;
    private getTranslation(key: TooltipKeyType) {
        return typeof key === "string" ? app.translator.trans(key) : app.translator.trans(key.key, key.params);
    }
    public add(priority: number, name: string, icon: IconType, tooltipKey: TooltipKeyType, style: StyleType) {
        this.tags.add(name, {
            type: "button",
            name,
            icon,
            tooltip: this.getTranslation(tooltipKey),
            style
        }, priority);
        return this;
    }
    public collect(priority: number, name: string, component: Mithril.ClassComponent | JSX.Element) {
        this.tags.add(name, {
            type: "collect",
            name,
            component
        }, priority);
    }
    public space(priority: number) {
        this.tags.add("space-" + (this.spaceKey++), {
            type: "space"
        }, priority);
        return this;
    }
    public group(priority: number, name: string, icon: IconType, tooltipKey: TooltipKeyType, callback: (tags: TagCollector) => void, rows: number = 1) {
        const newGroup = new TagCollector();
        callback(newGroup);
        this.tags.add(name, {
            type: "group",
            name,
            icon: icon,
            tooltip: this.getTranslation(tooltipKey),
            tags: newGroup,
            rows
        }, priority);
        return newGroup;
    }

    public item(key: string): Tags {
        return this.tags.get(key);
    }
    public clear() {
        Object.keys(this.tags.toObject()).forEach(k => this.tags.remove(k));
    }
    public remove(key: string) {
        this.tags.remove(key);
    }
    public get() {
        const arr = this.tags.toArray();
        const disabled: Record<string, boolean> = app.forum.attribute("bbcode-disable");
        return arr.filter(item => !disabled[item.itemName]).reverse();
    }
}