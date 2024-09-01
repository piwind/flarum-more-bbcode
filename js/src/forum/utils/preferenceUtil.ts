import app from "flarum/forum/app";
import { StyleType } from "../helper/tagCollector";

export function getValue<T>(key: string): T {
    let value = (app.session?.user?.preferences() || {})["xypp-more-bbcode-" + key] as T | null | undefined;
    if (!value) {
        value = app.forum.attribute<T>("xypp-more-bbcode-" + key);
    }
    return value;
}

export function selectBBCodeOrNormal(bbcode: StyleType, normal: StyleType) {
    return () => {
        if (prefMarkdown()) {
            return normal;
        }
        return bbcode;
    };
}

export function prefMarkdown() {
    const pref: "all" | "none" | "collected" = getValue("pref-markdown");
    if (pref === "all") return true;
    if (pref === "none") return false;
    return collectAll();
}

export function autoClose(): boolean {
    const close = getValue("auto-close") || "phone";
    return checkDevice(close);
}
export function collectAll(): boolean {
    return checkDevice(getValue("collect-all"));
}
export function removeMd(): boolean {
    return checkDevice(getValue("remove-markdown"));
}
export function collectMarkdown(): "none" | "first" | "sub" {
    return getValue("collect-markdown");
}

function checkDevice(target: "none" | "all" | "phone" | "tablet" | any): boolean {
    if (target == "none") return false;
    if (target == "all") return true;
    const current = app.screen();
    if (target === 'phone' && current === "phone") return true;
    if (target === "tablet" && (current === "phone" || current === "tablet")) return true;
    return false;
}