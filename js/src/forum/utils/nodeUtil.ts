export function showIf(judgement: boolean, vnode: any, def?: any) {
    return judgement ? vnode : (def || "");
}
export function prioritySerial(startValue: number, step: number): () => number {
    let value = startValue;
    return () => {
        const ret = value;
        value += step;
        return ret;
    };
}