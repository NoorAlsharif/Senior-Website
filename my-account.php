<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: loginorsign.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: loginorsign.php");
  }
?>
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
       
          <?php  if (isset($_SESSION['username'])) : ?>
            <li><p> <strong><?php echo $_SESSION['username']; ?></strong>   مرحباً</p></li>
            <li><button class="sign-out-btn"><a href="my-account.php?logout='1'">تسجيل الخروج</a></button></li>
<?php endif ?>
            <li></li>
            <li><a href="my-account.php">اعرض ادواتك</a></li>
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


        <form action="" class="login-form">
            <h3>تسجيل الدخول</h3>
            <?php include('errors1.php'); ?>
            <input type="email" placeholder="بريدك الالكتروني" class="box">
            <input type="password" placeholder="كلمة السر " class="box">
            <p>نسيت كلمة السر<a href="#">اضغط هنا</a></p>
            <p>ليس لديك حساب<a href="#"   onclick="document.getElementById('id01').style.display='block'"> انشاء حساب</a></p>
            <input type="submit" value="تسجيل الدخول" class="btn"  >
        </form>
       


        

        <div id="id01" class="modal">
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
          <form class="modal-content" action="/action_page.php">
          <?php include('errors.php'); ?>
            <div class="container">
              <h1 class="sp">تسجيل جديد</h1>
              <p class="sp">الرجاء تعبئة الحقول لإنشاء الحساب</p>
              <hr class="signhr">
              <div class="sdiv"><label for="email" class="slabel"><b>البريد الإلكتروني</b></label></div>
              <input type="text"  class="input1" placeholder="ادخل بريدك الالكتروني" name="email" required>
        
              <div class="sdiv"><label for="psw" class="slabel"><b>كلمة السر</b></label></div>
              <input type="password" class="input2" placeholder="ادخل كلمة السر" name="psw" required>
        
              <div class="sdiv"><label for="psw-repeat" class="slabel"><b>اعادة كمة السر</b></label></div>
              <input type="password" class="input2" placeholder="اعد كتابة كلمة السر" name="psw-repeat" required>
              
              <div class="sdiv"><label class="slabel"> 
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px  "> تذكرني
              </label></div>
        
              <p class="sp">بإنشائك حساب انت توافق على  <a href="#" style="color:dodgerblue">.السياسات والخصوصية</a></p>
        
              <div class="clearfix">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">إلغاء</button>
                <button type="submit"  class="sbuttons"class="signupbtn">تسجيل</button>
              </div>
            </div>
          </form>
        </div>
    
</section>

<section id ="products-header" class="section-p1" class="section-m1">

	
    

 

  

</section>



  <section>
  



    <div id="regForm">

        <div>  
   <div button class="button" id="view" style="width:95%"> <a href="addProduct.php"> 
  <span>اضافة منتج الى المتجر </span></button> </a>
      </div>
   
     <div button class="button1" id="delete" style="width:95%"> <a href="display.php"><span> عروضي     
     </span></button></a> </div>
  

    <div button class="button1" id="delete" style="width:95%"> <a href="reservation.php"><span> بياناتي    
    </span></button></a> </div>


    
  
  
      </div>
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