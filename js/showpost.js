function hide_section(user_type) 
{                                             
    
    var apb = document.getElementById('applybtn');
    var aps = document.getElementById('aps');
    
    console.log(user_type);
    
    if(user_type === 0){
        aps.style.visibility = "visible";
        apb.style.visibility = "hidden";
    }else{
        apb.style.visibility = "visible";
        aps.style.visibility = "hidden";
    }
    

}  