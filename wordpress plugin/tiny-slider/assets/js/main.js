;(function ($) {
    $(document).ready(function () {
        var slider = tns({
            container: '.slider',
            speed:300,
            autoplayTimeout:3000,
            items: 1,
            slideBy: 'page',
            autoplay: true,
            controls:false,
            autoHeight:true,
            nav:false
        });
    })
})(jQuery)
