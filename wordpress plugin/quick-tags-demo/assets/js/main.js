QTags.addButton("qtds-button-one","U","<gmap>","</gmap>")
QTags.addButton("qtds-button-two","JS",qtds_button_two);
QTags.addButton("qtds-button-three","FA",qtds_fa_preview);


function qtds_fa_preview(){
    tb_show("Fontawesome",qtds.preview)
}
function insertFA(icon){
    tb_remove()
    QTags.insertContent('<i class="'+icon+'"></i>')
}
function qtds_button_two(){
    var name=prompt("What is your name?")
    var text="Hello"+name
    QTags.insertContent(text)
}

