import { StyleArgs } from "../helper/tagCollector";

export function merge(...args: Partial<StyleArgs>[]){
    return Object.assign({}, ...args);
}
export function pair(p: string, s?: string, trim: boolean = true): Partial<StyleArgs> {
    if (!s) s = p;
    return { prefix: p, suffix: s, trimFirst: trim };
}
export function prefix(p: string, trim: boolean = true): Partial<StyleArgs> {
    return { prefix: p, trimFirst: trim };
}

export function bbcode(code: string, trim: boolean = false) {
    const regex = /\[([a-zA-Z0-9_-]+)/.exec(code);
    if (!regex) {
        return {}
    }
    const end = regex[1];
    return pair(code, `[/${end}]`, trim);
}