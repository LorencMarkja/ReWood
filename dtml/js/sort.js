function update() {
    var select = document.getElementById('select-sort');
    var value = select.options[select.selectedIndex].value;

    switch (value) {
        case "default":
            var $par = $('.prod-container');
            $par.find('.items').sort(function(a, b) {
                return + a.dataset.id -
                    + b.dataset.id;
            }).appendTo($par);
            break;
            break;
        case "newess":
            var $par = $('.prod-container');
            $par.find('.items').sort(function(a, b) {
                return + b.dataset.id -
                    + a.dataset.id;
            }).appendTo($par);
            break;
        case "ltoh":
            var $par = $('.prod-container');
            $par.find('.items').sort(function(a, b) {
                return + a.dataset.price -
                    + b.dataset.price;
            }).appendTo($par);
            break;
        case "htol":
            var $par = $('.prod-container');
            $par.find('.items').sort(function(a, b) {
                return + b.dataset.price -
                    + a.dataset.price;
            }).appendTo($par);
            break;
    }

}