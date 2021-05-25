;(function($){
    $(document).ready(function(){
        $('.toggle').minitoggle();
        let currentVal=$("#qr-toggle").val()
        if (currentVal==1){
            $(".minitoggle").addClass("active")
        }
        $('.toggle').on("toggle", function(e){
            if (e.isActive)
                $("#qr-toggle").val(1)
            else
                $("#qr-toggle").val(0)
        });
    })
})(jQuery)