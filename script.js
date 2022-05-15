let searchForm= document.querySelector('.search-form');

document.querySelector('#search-btn').onclick = () =>{
    searchForm.classList.toggle('active');
}



let loginForm= document.querySelector('.login-form');

document.querySelector('#login-btn').onclick = () =>{
    loginForm.classList.toggle('active');
}

//





window.onscroll=() =>{
    searchForm.classList.remove('active');
    loginForm.classList.remove('active')
    
    
}




var minSlider = document.getElementById('min');
var maxSlider = document.getElementById('max');

var outputMin = document.getElementById('min-value');
var outputMax = document.getElementById('max-value');

outputMin.innerHTML = minSlider.value;
outputMax.innerHTML = maxSlider.value;

minSlider.oninput = function(){
 outputMin.innerHTML=this.value;    
}

maxSlider.oninput = function(){
 outputMax.innerHTML=this.value;    
}



/*selection with chick box */

var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}


var expanded1 = false;

function showCheckboxes1() {
  var checkboxes1 = document.getElementById("checkboxes1");
  if (!expanded1) {
    checkboxes1.style.display = "block";
    expanded1 = true;
  } else {
    checkboxes1.style.display = "none";
    expanded1 = false;
  }
}


var expanded2 = false;

function showCheckboxes2() {
  var checkboxes2 = document.getElementById("checkboxes2");
  if (!expanded2) {
    checkboxes2.style.display = "block";
    expanded2 = true;
  } else {
    checkboxes2.style.display = "none";
    expanded2 = false;
  }
}




var expanded3= false;

function showCheckboxes3() {
  var checkboxes3 = document.getElementById("checkboxes3");
  if (!expanded3) {
    checkboxes3.style.display = "block";
    expanded3 = true;
  } else {
    checkboxes3.style.display = "none";
    expanded3 = false;
  }
}



// Get the modal signup page
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}




/*change lest content*/



function ChangeSecondList(value)
{
   if( value.length )
   {
      document.getElementById("static-list-div").style.display = "none";
      document.getElementById("dynamic-list-div").style.display = "block";
      var dropid = document.getElementById("dynamic-list");

     if (value=="الحياكة والتطريز")
      {
          dropid.options[1].text = " إبر";
          dropid.options[2].text = " خيوط";
          dropid.options[3].text = " أقمشة";
          dropid.options[4].text = "طارة";
          dropid.options[5].text = "غير ذلك";
          dropid.options[6].text = "الكل ";


          if(dropid.options[1].text =" إبر"){
            dropid.options[1].value= " إبر";
          } 

if(dropid.options[2].text = " خيوط"){
    dropid.options[2].value = "خيوط ";
}

if(dropid.options[3].text = " أقمشة"){
   dropid.options[3].value = "أقمشة";
}
if(dropid.options[4].text = " طارة"){
    dropid.options[4].value = "طارة";
}




if(dropid.options[5].text = " غير ذلك"){
   dropid.options[5].value = "غير ذلك";
}

if(dropid.options[6].text = "  الكل"){
   dropid.options[6].value = " الكل";
}

         
}        
        

      
         
      
   else if (value=="اللوحات")
      {
    
         dropid.options[1].text = "فرش";
         dropid.options[2].text = "مزيل لون";
         dropid.options[3].text = "الوان";
         dropid.options[4].text = " لوحة الوان";
         dropid.options[5].text = "غير ذلك";
         dropid.options[6].text = "الكل";
         
         if(dropid.options[1].text = "فرش"){
            dropid.options[1].value = "فرش";
         }
         if(dropid.options[2].text = "مزيل لون"){
            dropid.options[2].value = "مزيل لون";
         }
         if(dropid.options[3].text = "الوان"){
            dropid.options[3].value = "الوان";
         }

         if(dropid.options[4].text = "لوحة الوان"){
            dropid.options[4].value = "لوحة الوان";
         }

        

         if(dropid.options[5].text = "غير ذلك"){
            dropid.options[5].value = "غير ذلك";
         }

         if(dropid.options[6].text = "الكل"){
            dropid.options[6].value = "الكل";
         }
        
      }
   else if (value=="الخزف والزجاج")
      {
 
         dropid.options[1].text = "ادوات نحت";
         dropid.options[2].text = " صحن دوار";
         dropid.options[3].text = "قوالب تشكيل";
         dropid.options[4].text = "غير ذلك ";
         dropid.options[5].text = " الكل";
         dropid.options[6].style.display = 'none'


         
        if(dropid.options[1].text = "ادوات نحت"){
            dropid.options[1].value = "أدوات نحت";
        }

        if(dropid.options[2].text = "صحن دوار"){
         dropid.options[2].value = " صحن دوار";
         
     }
        if(dropid.options[3].text = "قوالب تشكيل "){
            dropid.options[3].value = "قوالب تشكيل";
        }
        if(dropid.options[4].text = "غير ذلك"){
            dropid.options[4].value = "غير ذلك";
            
        }

        if(dropid.options[5].text = " الكل"){
         dropid.options[5].value = " الكل";
         
     }


    
      
      
  


   
   }  
        
        
      
      dropid.options[0].selected = true;
      
   }
   else
   {
      document.getElementById("static-list-div").style.display = "block";
      document.getElementById("dynamic-list-div").style.display = "none";
   }
}

ChangeSecondList(document.getElementById("section").options[document.getElementById("section").selectedIndex].value);











