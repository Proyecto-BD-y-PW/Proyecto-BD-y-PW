const radio1_btn = document.getElementById("radio-1");
const select1_btn = document.getElementById("eliminaciones");
const select2_btn = document.getElementById("elim-id");
const select3_btn = document.getElementById("elim-fecha");
const input_fecha = document.querySelectorAll(".consultar-mode .formulario #fecha");
const contenedor=document.querySelector(".contenedor");


const select6_btn = document.getElementById("consultas");
const select7_btn = document.getElementById("consultas-id");
const select8_btn = document.getElementById("consultas-fecha");

const registrar_mode = document.querySelector(".registrar-mode");
const eliminar_mode = document.querySelector(".eliminar-mode");
const actualizar_mode = document.querySelector(".actualizar-mode");
const consultar_mode = document.querySelector(".consultar-mode");
var band1=true;
var band2=false;
var band3=false;
var band4=false;


select1_btn.addEventListener('change',function(){
    
    var opcion_seleccionada=this.options[select1_btn.selectedIndex];
    if(opcion_seleccionada.value==='unico-id'){
        select2_btn.classList.remove("remove");
        select2_btn.setAttribute("required","");
        select3_btn.classList.add("remove");
        select3_btn.removeAttribute("required","");
    
    }else if(opcion_seleccionada.value==='unico-fecha'){
        select2_btn.classList.add("remove");
        select2_btn.removeAttribute("required","");
        select3_btn.classList.remove("remove");
        select3_btn.setAttribute("required","");
    
    }else if(opcion_seleccionada.value==="rango-fecha"){
        
        select2_btn.classList.add("remove");
        select2_btn.removeAttribute("required","");
        select3_btn.classList.add("remove");
        select3_btn.removeAttribute("required","");
             
    }else{
        select2_btn.classList.add("remove");
        select2_btn.removeAttribute("required","");
        select3_btn.classList.add("remove");
        select3_btn.removeAttribute("required","");
        
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
     /*   contenedor.style.overflow='hidden';
     */   eliminar_mode.classList.add('eliminar-mode-add');
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
 
    
});


select6_btn.addEventListener('change',function(){
    
    var opcion_seleccionada=this.options[select6_btn.selectedIndex];
    if(opcion_seleccionada.value==='unico-i'){
        select7_btn.classList.remove("remove");
        select7_btn.setAttribute("required","");
        select8_btn.classList.add("remove");
        select8_btn.removeAttribute("required","");
        input_fecha[0].classList.add("remove");
        input_fecha[1].classList.add("remove");
        input_fecha[1].removeAttribute("required","");
        input_fecha[2].classList.add("remove");
        input_fecha[3].classList.add("remove");
        input_fecha[3].removeAttribute("required","");
        
    }else if(opcion_seleccionada.value==='unico-f'){
        select7_btn.classList.add("remove");
        select7_btn.removeAttribute("required","");
        select8_btn.classList.remove("remove");
        select8_btn.setAttribute("required","");
        input_fecha[0].classList.add("remove");
          
        input_fecha[1].classList.add("remove");
        input_fecha[1].removeAttribute("required","");
        input_fecha[2].classList.add("remove");
        input_fecha[3].classList.add("remove");
        input_fecha[3].removeAttribute("required","");
        
    }else if(opcion_seleccionada.value==='rango-fecha'){
        select7_btn.classList.add("remove");
        select7_btn.removeAttribute("required","");
        select8_btn.classList.add("remove");
        select8_btn.removeAttribute("required","");
        input_fecha[0].classList.remove("remove");
         
        input_fecha[1].classList.remove("remove");
        input_fecha[1].setAttribute("required","");
        input_fecha[2].classList.remove("remove");
        input_fecha[3].classList.remove("remove");
        input_fecha[3].setAttribute("required","");
        
    }else{
        select7_btn.classList.add("remove");
        select7_btn.removeAttribute("required","");
        select8_btn.classList.add("remove");
        select8_btn.removeAttribute("required","");
        input_fecha[0].classList.add("remove");
          
        input_fecha[1].classList.add("remove");
        input_fecha[1].removeAttribute("required","");
        input_fecha[2].classList.add("remove");
        input_fecha[3].classList.add("remove");
        input_fecha[3].removeAttribute("required","");
        
    }
     
});



radio1_btn.click();

