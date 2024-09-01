export default function align(base: JQuery, elem: JQuery) {
    const parentOffset = base.offsetParent()?.offset()?.left || 0;
    const realLeft = base.offset()?.left || 0;
    const screenWid = $(document.body).width() || 0;
    let targetWidth = elem.width() || 0;
    let globalOffset = realLeft;

    if (globalOffset + targetWidth > screenWid) {
        globalOffset = screenWid - targetWidth;
    }
    if (globalOffset < 0) globalOffset = 0;

    elem.css({
        left: globalOffset - parentOffset
    });
}