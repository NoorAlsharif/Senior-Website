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


include 'config.php';
include 'connection.php';

    $productId = $_SESSION['username'];

    /*
     * Get the product details.
     */
     if (isset($_SESSION['username'])) 
       {
    $sql = 'SELECT * 
            FROM products 
            WHERE user = ? 
            ';

    $statement = $connection->prepare($sql);

    $statement->bind_param('s', $productId);

    $statement->execute();

  
    $result = $statement->get_result();

   
    $products = $result->fetch_all(MYSQLI_ASSOC);

  
    $result->close();

    $statement->close();


echo "<table border='1' style=' width: 15%;
min-width: 150px;
padding: 10px 12px;
border: 1px solid #cce7d0;
border-radius: 25px;

box-shadow: 20px 20px 30px rgba(0, 0, 0, 0.02);
margin: 150px 150px;
transition: 0.2s ease;
text-align: center;
background-color: #e8f6ea;
'>
 <tr>
 
 <th>الاسم</th>
 <th>الصورة</th>
 <th>القيمة</th>
 <th>الوصف</th>
 <th>الحالة </th>
 <th>المدينة</th>
 <th>القسم</th>
 <th>النوع</th>
 <th>الجوال</th>
 <th>البريد الإلكتروني</th>
 </tr>";
 

foreach($products as $product)
   {
   echo "<tr>";
   echo "<td>" . $product['name'] . "</td>";

   $productid= $product['id'];
   $sql = 'SELECT * 
   FROM products_images 
   WHERE product_id = ?';

$statement = $connection->prepare($sql);

$statement->bind_param('i', $productid);

$statement->execute();

$result = $statement->get_result();

$images = $result->fetch_all(MYSQLI_ASSOC);


foreach ($images as $image) {
    $imageId = $image['id'];
    $imageFilename = $image['filename'];
    
   
      echo"  <td> <img width='150' height='100' src='" .$imageFilename . "' alt='' /> </td>";
             
}
  echo "<td>" . $product['quantity'] . "</td>";	
   echo "<td>" . $product['description'] . "</td>";
   echo "<td>" . $product['status'] . "</td>";
   echo "<td>" . $product['city'] . "</td>";
   echo "<td>" . $product['section'] . "</td>";
   echo "<td>" . $product['kind'] . "</td>";
   echo "<td>" . $product['phone'] . "</td>";
   echo "<td>" . $product['email'] . "</td>";


   

if (isset($_POST['delete'])) 
{
  $sql = 'DELETE FROM products WHERE id = ?';

$statement = $connection->prepare($sql);

$statement->bind_param('i', $productid);

$statement->execute();

header('location: my-account.php');
  
  
  
  

  if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $conn->error;
  }}
 



   echo "</tr>";
echo <<<"buttons"
  <td>
  <form name="adddelete"    method="post" >

     <input class="button_normal" type="submit" value="حذف"  name="delete" style='   margin-top: 5px;
     display:inline-block;
     padding: 10px;
     font-size: 13px;
     border-radius: 2px;
     border: 4px solid var(--black);
     color:#000000;
     background: #fcf3d7;' />
     <input class="button_normal" type="button"  value="تعديل" onclick=""  style='   margin-top: 5px;
     display:inline-block;
     padding: 10px;
     font-size: 13px;
     border-radius: 2px;
     border: 4px solid var(--black);
     color:#000000;
     background: #fcf3d7;'/>
     </form>
  </td>    
buttons;
   }
 echo "</table>";

       }