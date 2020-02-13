String.prototype.toPersianDigit = function () {
    var id = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return this.replace(/[0-9]/g, function (w) {
        return id[+w]
    });
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

chInp('#price');
chInp('#donation');
chInp('#custom_donation');
chInp('input[name^="donate_count"]');