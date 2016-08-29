(function (window) {
               
    window.Number.zeroFill = function (value, width, fillStyle) {
        fillStyle = fillStyle || '0';
        value = value + '';
        return value.length >= width ? value : new Array(width - value.length + 1).join(fillStyle) + value;
    }

    window.Date.prototype.toSimpleKorStyle = function () {
        return [
            this.getHours() > 12 ? "오후" : "오전",
            " ",
            Number.zeroFill(this.getHours() > 12 ? this.getHours() - 12 : this.getHours(), 2),
            ":",
            Number.zeroFill(this.getMinutes(), 2)
        ].join('');
    }
    
})(this);