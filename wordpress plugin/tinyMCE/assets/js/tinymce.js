;(function(){
    tinyMCE.PluginManager.add("tmcd_plugin",function(editor,url){
        editor.addButton("tmcd_button_one",{
            //text:"B1",
            icon:"drop",
            onclick:function(){
                editor.insertContent("[gmap]Content goes to here[/gmap]")
            }
        });
        editor.addButton("tmcd_listbox_one",{
            type:"listbox",
            text:"Select SomeThing",
            values:[
                {text:"Apple",value:"You have selected <b>Apple</b>"},
                {text:"Orange",value:"You have selected <b>Orange</b>"},
                {text:"Grape",value:"You have selected <b>Grape</b>"},
                {text:"Banana",value:"You have selected <b>Banana</b>"},
            ],
            onselect:function(){
                editor.insertContent(this.value())
            },
            onPostRender:function(){
                this.value("You have selected <b>Banana</b>")
            }
        });
        editor.addButton("tmcd_menu_one",{
            type:"menubutton",
            text:"Choices",
            menu:[
               {text:"Option A",onclick:function(){console.log("Option A")}},
               {text:"Option B",onclick:function(){console.log("Option B")}},
               {text:"Option C",menu:[
                {text:"Option C-1",onclick:function(){console.log("Option C-1")}},
                {text:"Option C-2",onclick:function(){console.log("Option C-2")}},
                {text:"Option C-3",onclick:function(){console.log("Option C-3")}},
                {text:"Option C-4",menu:[
                    {text:"Option C-4-1",onclick:function(){console.log("Option C-4-1")}},
                    {text:"Option C-4-2",onclick:function(){console.log("Option C-4-2")}},
                    {text:"Option C-4-3",onclick:function(){console.log("Option C-4-3")}},
                   ]},
               ]},
               {text:"Option D",onclick:function(){console.log("Option D")}},
            ]
        });
        editor.addButton("tmcd_form_button",{
            text:"Form",
            onclick:function(){
                editor.windowManager.open({
                    title:"User Input Form",
                    body:[
                        {
                            type:"textbox",
                            name:"userinput1",
                            label:"Your Name",
                            value:"Hello"
                        },
                        {
                            type:"colorpicker",
                            name:"userinput2",
                            label:"your Color",
                            value:"#252525"
                        },
                        {
                            type:"listbox",
                            name:"userinput3",
                            label:"Options",
                            values:[
                                {text:"Option 01",value:1},
                                {text:"Option 02",value:2},
                                {text:"Option 03",value:3},
                                {text:"Option 04",value:4},
                            ]
                        },
                    ],
                    onsubmit:function(e){
                        console.log(e.data.userinput1)
                        editor.insertContent("name="+e.data.userinput1+";color="+e.data.userinput2)
                    }
                })
            }
    
            
        });
       
    });
})()