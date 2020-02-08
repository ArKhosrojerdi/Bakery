String.prototype.toPersianDigit = function () {
    var id = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return this.replace(/[0-9]/g, function (w) {
        return id[+w]
    });
};

String.prototype.toEnglishDigit = function () {
    var find = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    var replace = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    var replaceString = this;
    var regex;
    for (var i = 0; i < find.length; i++) {
        regex = new RegExp(find[i], "g");
        replaceString = replaceString.replace(regex, replace[i]);
    }
    return replaceString;
};

function chInp(idName) {
    $(idName).each(function () {
        var elem = $(this);
        elem.data('oldVal', elem.val());
        elem.bind("propertychange change click keyup input paste", function (event) {
            // If value has changed...
            if (elem.data('oldVal') !== elem.val()) {
                // Updated stored value
                elem.data('oldVal', elem.val());
                this.value = this.value.toPersianDigit();
            }
        });
    });
}

chInp('#code');
chInp('#amount');
chInp('#price');