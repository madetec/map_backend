

$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
    $('#phoneform-number').inputmask({
        mask: "+XX8 (##) ### ####",
        definitions: {
            'X': {
                validator: "9",
                placeholder: "9"
            }
        }
    });
    $('#carform-number').inputmask("99 999 aaa");
    let cars = $('[data-color]');
    for (let i = 0; i < cars.length; i++) {
        let hex = $(cars[i]).attr('data-color');
        let invert = invertColor(hex);
        $(cars[i]).css({"background-color": invert, "padding": "5px", "border-radius": "5px"});
    }
});


// functions
function invertColor(hex) {
    if (hex.indexOf('#') === 0) {
        hex = hex.slice(1);
    }
    if (hex.length === 3) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
    if (hex.length !== 6) {
        throw new Error('Invalid HEX color.');
    }
    let r = (255 - parseInt(hex.slice(0, 2), 16)).toString(16),
        g = (255 - parseInt(hex.slice(2, 4), 16)).toString(16),
        b = (255 - parseInt(hex.slice(4, 6), 16)).toString(16);
    return '#' + padZero(r) + padZero(g) + padZero(b);
}

function padZero(str, len) {
    len = len || 2;
    let zeros = new Array(len).join('0');
    return (zeros + str).slice(-len);
}
