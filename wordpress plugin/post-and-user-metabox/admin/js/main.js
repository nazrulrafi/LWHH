var frame;
var gframe;
;(function ($) {
    $(document).ready(function () {
        let img_url=$("#omb_image_url").val();
        if (img_url){
            $("#image_container").html(`<img src="${img_url}">`)
        }
        let img_urls=$("#omb_gallery_urls").val();
        img_urls=img_urls?img_urls.split(";"):array()
        for(i in img_urls){
            _img_url=img_urls[i]
            $("#gallery_container").append(`<img style="margin: 5px" src="${_img_url}">`)
        }
        $( "#datepicker" ).datepicker();
        $("#upload-image").click(function () {
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Insert Image'
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });
            frame.on( 'select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $("#omb_image_id").val(attachment.id)
                $("#omb_image_url").val(attachment.sizes.thumbnail.url)
                $("#image_container").html(`<img src='${attachment.sizes.thumbnail.url}'>`)
            })
            frame.open();
            return false;
        })
        $("#upload-gallery").click(function () {
            if(gframe){
                gframe.open();
                return false;
            }
            gframe = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Insert Image'
                },
                multiple: true  // Set to true to allow multiple files to be selected
            });
            gframe.on( 'select', function() {
                var attachments = gframe.state().get('selection').toJSON();
                let img_ids=[];
                let img_urls=[];
                $("#gallery_container").html("");
                for (i in attachments){
                    let attachment=attachments[i]
                    img_ids.push(attachment.id)
                    img_urls.push(attachment.sizes.thumbnail.url)
                    $("#gallery_container").append(`<img style="margin: 5px" src="${attachment.sizes.thumbnail.url}">`)
                }
                $("#omb_gallery_ids").val(img_ids.join(";"))
                $("#omb_gallery_urls").val(img_urls.join(";"))

            })
            gframe.open();
            return false;
        })
    })
})(jQuery)