<?php include('server.php') ?>
<!DOCTYPE html>
<html >

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Used Art tool</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="style.css">


    
</head>

<body>
    <section id="header">
                
                
                
        <div>
           
            <ul id="navbar">
               <li> <div class="fas fa-user" id="login-btn"></div></li>
              <li>  <div class="fas fa-search" id="search-btn"></div></li>
                <li></li>
                <li><a href="loginorsign.php">اعرض ادواتك</a></li>
                <li><a href="store.html">ادوات مستخدمة</a></li>
                <li><a href="store.html">ادوات جديدة</a></li>
                <li><a href="store.html">ادوات مجانية</a></li>
                 <li><a class="active" href="index.php"> الصفحة الرئيسية</a></li>
                
            </ul>

        </div>
        <a href="#"><img src="img/" class="logo" alt=""></a> 


            <form action="" class="search-form">
                <label for="search-box" class="fas fa-search"></label>

                <input type="search" id="search-box" placeholder=".......ابحث هنا">
            </form>


            <form method="post" class="login-form" action="#" id="loginform">
            <?php include('errors1.php'); ?>
                <h3>تسجيل الدخول</h3>
                <input type="text" placeholder="اسم المستخدم" class="box"  name="username1">
                <input type="password" placeholder="كلمة السر " class="box" name="password">
                <p>نسيت كلمة السر<a href="#">اضغط هنا</a></p>
                <p>ليس لديك حساب<a href="#"   onclick="document.getElementById('id01').style.display='block'"> انشاء حساب</a></p>
                <input type="submit" value="تسجيل الدخول" class="btn" name="login_user" >
            </form>
           


            

            <div id="id01" class="modal">
              <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
              <form name="signform" class="modal-content" action="#"  method="post" >
              <?php include('errors.php'); ?>
                <div class="container">
                  <h2 class="sp"> إنشاء حساب</h2>
                  <p class="sp">الرجاء تعبئة الحقول لإنشاء الحساب</p>
                  <hr class="signhr">

                  <input type="text"  class="input1" placeholder=" اسم المستخدم" name="username" value="<?php echo $username; ?>" >
                  

                  <input type="text"  class="input1" placeholder=" البريدالالكتروني" name="email" value="<?php echo $email; ?>" >

                  <input type="password" class="input2" placeholder=" كلمة السر" name="password_1" >

                  <input type="password" class="input2" placeholder="اعادة كتابة كلمة السر" name="password_2" >

            
                  <p class="sp">بإنشائك حساب انت توافق على  <a href="#" >.السياسات والخصوصية</a></p>
            
                  <div class="clearfix">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn" >إلغاء</button>
                    <button type="submit" name="reg_user" class="sbuttons"  >تسجيل</button>
                  </div>
                </div>
              </form>



              



            </div>
        
    </section>

    <section id="signup" class="section-p1 section-m1">
        <div class="form">
            <button class="normal"  onclick="document.getElementById('id01').style.display='block'">  التسجيل كمستخدم جديد </button>
            <button class="normal"  onclick="document.querySelector('.login-form').classList.toggle('active');">    تسجيل الدخول </button>

        </div>

     <div class="sign">
         <h4> سجل لعرض أدواتك</h4>
         <p>لتتمكن من عرض أدواتك سجل دخولك أولا</p> 
     </div>
     
    </section>
    <footer class="section-p1">
        
        <div class="col">
                <h4>تابعنا على قنوات التواصل </h4>
                <img class="logo" src="img/" alt="">
               
                <div class="follow">
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-pinterest"></i>
                </div>
                </div>
    
            </div>
    
            <div class="col">
            <h4>من نحن</h4>
            <a href="#">عنا</a>
            
        </div>
    
        <div class="col">
            <h4>حسابي</h4>
            <a href="#">تسجيل الدخول</a>
           
        </div>
    
        <div class="copyright">@2021 all copyright are reserved</div>
        
        </footer>
    
    
    
        <script src="script.js"></script>
    
    
      
    
    </body>
    
    
    
    
    
    </html>