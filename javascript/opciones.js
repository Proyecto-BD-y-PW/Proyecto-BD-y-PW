const radio1_btn = document.getElementById("radio-1");
const select1_btn = document.getElementById("consultas");
const select2_btn = document.getElementById("disponibles");


/*const registrar_mode = document.querySelector(".registrar-mode");*/
/*const registrar_mode = document.getElementsByClassName("registrar-mode");
const eliminar_mode = document.getElementsByClassName("eliminar-mode");
const actualizar_mode = document.getElementsByClassName("actualizar-mode");
const consultar_mode = document.getElementsByClassName("consultar-mode");*/
const registrar_mode = document.querySelector(".registrar-mode");
const eliminar_mode = document.querySelector(".eliminar-mode");
const actualizar_mode = document.querySelector(".actualizar-mode");
const consultar_mode = document.querySelector(".consultar-mode");
var band1=true;
var band2=false;
var band3=false;
var band4=false;
/*
radio1_btn.addEventListener('click', () => {
    registrar_mode.classList.add("registrar-mode-add");
    eliminar_mode.classList.add("eliminar-mode-remove");
});

radio2_btn.addEventListener('click', () => {
    
    registrar_mode.classList.add("registrar-mode-remove");
    eliminar_mode.classList.add("eliminar-mode-add");
    });

*/
select1_btn.addEventListener('change',function(){
    
    var opcion_seleccionada=this.options[select1_btn.selectedIndex];
    if(opcion_seleccionada.value=='unico'){
        select2_btn.classList.remove("remove");
        select2_btn.setAttribute("required","");
        
    }else{
        select2_btn.classList.add("remove");
        select2_btn.removeAttribute("required","");
    }
});
radio1_btn.addEventListener('click', function()  {
    
    if(band1===true){
      registrar_mode.classList.add("registrar-mode-add");
        consultar_mode.classList.remove("consultar-mode-add");
         band1=false;
        band2=true;
        band3=false;
        band4=false;
    
    }else if(band2===true){
    
        eliminar_mode.classList.add('eliminar-mode-add');
       registrar_mode.classList.remove("registrar-mode-add");
        band2=false;
        band1=false;
        band3=true;
        band4=false;
    
    }else if(band3===true){
      
        actualizar_mode.classList.add('actualizar-mode-add');
        eliminar_mode.classList.remove("eliminar-mode-add");
        band3=false;
        band1=false;
        band2=false;
        band4=true;
    
    }else if(band4===true){
        consultar_mode.classList.add('consultar-mode-add');
        actualizar_mode.classList.remove("actualizar-mode-add");
        band4=false;
        band3=false;
        band2=false;
        band1=true;
    
    }
    
  /* radio1_btn.click();
  */  
    
});


radio1_btn.click();