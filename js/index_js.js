// JavaScript Document
var kf=1;
function showMes(_id,_mes){
	document.getElementById(_id).innerHTML = _mes;
};

//  Check Customer Name
function name(str){
	var  reg_name = /^[a-zA-Z]+$/;
	return reg_name.test(str);
};

//  Check Email
function email(str){
	var reg_email = /^[a-zA-Z0-9\.\,\-\_]+\@[a-z0-9]+\.[a-z]{3,5}(\.[a-z]{2,5})?$/;
	return reg_email.test(str);
};

//  Check PhoneNumber
function phone(str){
    var reg_phone = /^[0-9\+\-\.]{10,15}$/;
    return reg_phone.test(str);
}; 


//  Function sendMess
function checkcontent(){
    var f = document.forms["frmContact"];
    var Content = f.CustomerContent.value;
    if(Content == ""){
        showMes("noti_content","* Please Enter Your Message");
        f.CustomerContent.style.border = "2px solid rgb(255, 187, 0)";
        kf=0;
    }else{
        showMes("noti_content","");
        f.CustomerContent.style.border = "1px solid #fff";
        kf=1;
    }
};
function checkname(){
    var f = document.forms["frmContact"];
    var Name = f.CustomerName.value;
    if(Name == ""){
        showMes("noti_name","* Please Enter Your Name");
        f.CustomerName.style.border = "2px solid rgb(255, 187, 0)";
        kf=0;
    }else if(!name(Name)){
        showMes("noti_name","* Invaild Name");
        f.CustomerName.style.border = "2px solid rgb(255, 187, 0)";
        kf=0;
    }else{
        showMes("noti_name","");
        
        f.CustomerName.style.border = "1px solid #fff";
        kf=1;
    };
};
function checkemail(){
    var f = document.forms["frmContact"];
    var Email = f.CustomerEmail.value;
    if(Email == ""){
        showMes("noti_email","* Please Enter Your Email");
        f.CustomerEmail.style.border = "2px solid rgb(255, 187, 0)";
        kf=0;
    }else if(!email(Email)){
        showMes("noti_email","* Invaild Email");
        f.CustomerEmail.style.border = "2px solid rgb(255, 187, 0)";
        kf=0;
    }else{
        showMes("noti_email","");
        f.CustomerEmail.style.border = "1px solid #fff";
        kf=1;
    };
};
function checkphone(){
    var f = document.forms["frmContact"];
    var Phone = f.CustomerPhone.value; 
    if(Phone == ""){
        showMes("noti_phone","* Please Enter Your Phone Number");
        f.CustomerPhone.style.border = "2px solid rgb(255, 187, 0)";
        kf=0;
    }else if(!phone(Phone)){
        showMes("noti_phone","* Invaild Phone Number");
        f.CustomerPhone.style.border = "2px solid rgb(255, 187, 0)";
        kf=0;
    }else{
        showMes("noti_phone","");
        f.CustomerPhone.style.border = "1px solid #fff";
        kf=1;
    };
};
