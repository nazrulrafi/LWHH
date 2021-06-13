;(function($){
    var exitModal=[];
    var popupDisplay=false
    var delayedPopups = [];
    $(document).ready(function(){
        PlainModal.closeByEscKey = false;
        PlainModal.closeByOverlay = false;
        var modalslet=document.querySelectorAll(".modal-content")
        for(var i=0;modalslet.length;i++){
            var content=modalslet[i]
            var modal=new PlainModal(content)
            var delay=modalslet[i].getAttribute("data-delay")
            modal.closeButton=content.querySelector(".close-button")
            if(modalslet[i].getAttribute("data-exit")=="1"){
                if(delay > 0){
                    delayedPopups.push({modal: modal, delay: delay});  
                }else{
                    modal.open()
                }
            }else{
                exitModal.push(modal)
            }
           
        }
        console.log(delayedPopups);
        for (i in delayedPopups) {
            setTimeout(function (i) {
                console.log(i);
                delayedPopups[i].modal.open();
            }, delayedPopups[i].delay, i);
        } 
    })
    if(exitModal.length >0){
        window.onbeforeunload=function(){
            if(!popupDisplay){
                for(i in exitModal){
                    exitModal[i].open()
                }
                popupDisplay=true
                return "random"
            }
        }
    }
    
})(jQuery)