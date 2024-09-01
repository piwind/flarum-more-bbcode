import app from "flarum/forum/app";
import { StyleType } from "../helper/tagCollector";

export function selectBBCodeOrNormal(bbcode: StyleType, normal: StyleType) {
    return () => {
        if (prefMarkdown()) {
            return normal;
        }
        return bbcode;
    };
}

export function prefMarkdown() {
    const pref: "all" | "none" | "collected" = (app.session?.user?.preferences() || {})["xypp-bbcode-more-pref-markdown"] || "none";
    if (pref === "all") return true;
    if (pref === "none") return false;
    return
}

export function autoClose(): boolean {
    const close = (app.session?.user?.preferences() || {})["xypp-bbcode-more-auto-close"] || "phone";
    return checkDevice(close);
}
export function collectAll(): boolean {
    return checkDevice(app.forum.attribute("xypp-more-bbcode-collect_all"));
}
export function removeMd(): boolean {
    return checkDevice(app.forum.attribute("xypp-more-bbcode-remove_markdown"));
}
export function collectMarkdown(): "none" | "first" | "sub" {
    return app.forum.attribute("xypp-more-bbcode-collect_markdown");
}

function checkDevice(target: "none" | "all" | "phone" | "tablet"): boolean {
    if (target == "none") return false;
    if (target == "all") return true;
    const current = app.screen();
    if (target === 'phone' && current === "phone") return true;
    if (target === "tablet" && (current === "phone" || current === "tablet")) return true;
    return false;
}