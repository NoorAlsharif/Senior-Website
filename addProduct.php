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

$productSaved = FALSE;

if (isset($_POST['submit'])) {
    /*
     * Read posted values.
     */
    $productName = isset($_POST['name']) ? $_POST['name'] : '';
    $productQuantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
    $productDescription = isset($_POST['description']) ? $_POST['description'] : '';
    $productStatus=isset($_POST['Tstatus']) ? $_POST['Tstatus'] : '';
    $productCity=isset($_POST['Tcity']) ? $_POST['Tcity'] : '';
    $productSection=isset($_POST['Tsection']) ? $_POST['Tsection'] : '';
    $productType=isset($_POST['Ttype']) ? $_POST['Ttype'] : '';
    $productPhone=isset($_POST['Tphone']) ? $_POST['Tphone'] : '';
    $productEmail=isset($_POST['Temail']) ? $_POST['Temail'] : '';
    $productUser=isset($_POST['id']) ? $_POST['id'] : '';

    /*
     * Validate posted values.
     */
    if (empty($productName)) {
        $errors[] = 'Please provide a product name.';
    }

    if ($productQuantity == 0) {
        $errors[] = 'Please provide the quantity.';
    }

    if (empty($productDescription)) {
        $errors[] = 'Please provide a description.';
    }

    if (empty($productStatus)) {
        $errors[] = 'Please provide a status.';
    }

    if (empty($productCity)) {
        $errors[] = 'Please provide a city.';
    }

    if (empty($productSection)) {
        $errors[] = 'Please provide a section.';
    }

    if (empty($productType)) {
        $errors[] = 'Please provide a type.';
    }
    if (empty($productEmail) && empty($productPhone)) {
        $errors[] = 'Please provide a phone or email.';
    }
    /*
     * Create "uploads" directory if it doesn't exist.
     */
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0777, true);
    }

    /*
     * List of file names to be filled in by the upload script 
     * below and to be saved in the db table "products_images" afterwards.
     */
    $filenamesToSave = [];

    $allowedMimeTypes = explode(',', UPLOAD_ALLOWED_MIME_TYPES);

    /*
     * Upload files.
     */
    if (!empty($_FILES)) {
        if (isset($_FILES['file']['error'])) {
            foreach ($_FILES['file']['error'] as $uploadedFileKey => $uploadedFileError) {
                if ($uploadedFileError === UPLOAD_ERR_NO_FILE) {
                    $errors[] = 'You did not provide any files.';
                } elseif ($uploadedFileError === UPLOAD_ERR_OK) {
                    $uploadedFileName = basename($_FILES['file']['name'][$uploadedFileKey]);

                    if ($_FILES['file']['size'][$uploadedFileKey] <= UPLOAD_MAX_FILE_SIZE) {
                        $uploadedFileType = $_FILES['file']['type'][$uploadedFileKey];
                        $uploadedFileTempName = $_FILES['file']['tmp_name'][$uploadedFileKey];

                        $uploadedFilePath = rtrim(UPLOAD_DIR, '/') . '/' . $uploadedFileName;

                        if (in_array($uploadedFileType, $allowedMimeTypes)) {
                            if (!move_uploaded_file($uploadedFileTempName, $uploadedFilePath)) {
                                $errors[] = 'The file "' . $uploadedFileName . '" could not be uploaded.';
                            } else {
                                $filenamesToSave[] = $uploadedFilePath;
                            }
                        } else {
                            $errors[] = 'The extension of the file "' . $uploadedFileName . '" is not valid. Allowed extensions: JPG, JPEG, PNG, or GIF.';
                        }
                    } else {
                        $errors[] = 'The size of the file "' . $uploadedFileName . '" must be of max. ' . (UPLOAD_MAX_FILE_SIZE / 1024) . ' KB';
                    }
                }
            }
        }
    }

    /*
     * Save product and images.
     */
    if (!isset($errors)) {
        /*
         * The SQL statement to be prepared. Notice the so-called markers, 
         * e.g. the "?" signs. They will be replaced later with the 
         * corresponding values when using mysqli_stmt::bind_param.
         * 
         * @link http://php.net/manual/en/mysqli.prepare.php
         */
        $sql = 'INSERT INTO products (
                    name,
                    quantity,
                    description,status,city,section,kind,phone,email,user
                ) VALUES (
                    ?, ?, ?,?,?,?,?,?,?,?
                )';

        /*
         * Prepare the SQL statement for execution - ONLY ONCE.
         * 
         * @link http://php.net/manual/en/mysqli.prepare.php
         */
        $statement = $connection->prepare($sql);

        /*
         * Bind variables for the parameter markers (?) in the 
         * SQL statement that was passed to prepare(). The first 
         * argument of bind_param() is a string that contains one 
         * or more characters which specify the types for the 
         * corresponding bind variables.
         * 
         * @link http://php.net/manual/en/mysqli-stmt.bind-param.php
         */
        $statement->bind_param('sissssssss', $productName, $productQuantity, $productDescription,$productStatus,$productCity,$productSection,$productType,$productPhone,$productEmail,$productUser);

        /*
         * Execute the prepared SQL statement.
         * When executed any parameter markers which exist will 
         * automatically be replaced with the appropriate data.
         * 
         * @link http://php.net/manual/en/mysqli-stmt.execute.php
         */
        $statement->execute();

        // Read the id of the inserted product.
        $lastInsertId = $connection->insert_id;

        /*
         * Close the prepared statement. It also deallocates the statement handle.
         * If the statement has pending or unread results, it cancels them 
         * so that the next query can be executed.
         * 
         * @link http://php.net/manual/en/mysqli-stmt.close.php
         */
        $statement->close();

        /*
         * Save a record for each uploaded file.
         */
        foreach ($filenamesToSave as $filename) {
            $sql = 'INSERT INTO products_images (
                        product_id,
                        filename
                    ) VALUES (
                        ?, ?
                    )';

            $statement = $connection->prepare($sql);

            $statement->bind_param('is', $lastInsertId, $filename);

            $statement->execute();

            $statement->close();
        }

        /*
         * Close the previously opened database connection.
         * 
         * @link http://php.net/manual/en/mysqli.close.php
         */
        $connection->close();

        $productSaved = TRUE;

        /*
         * Reset the posted values, so that the default ones are now showed in the form.
         * See the "value" attribute of each html input.
         */
        $productName = $productQuantity = $productDescription =$productStatus =$productCity =$productSection =$productType =$productPhone =$productEmail =$productUser = NULL;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
        <meta charset="UTF-8" />
        <!-- The above 3 meta tags must come first in the head -->

        <title>Save product details</title>

        <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
        <style type="text/css">
            body {
                padding: 30px;
            }

            .form-container {
                margin-left: 80px;
            }

            .form-container .messages {
                margin-bottom: 15px;
            }

            .form-container input[type="text"],
            .form-container input[type="number"] {
                display: block;
                margin-bottom: 15px;
                width: 150px;
            }

            .form-container input[type="file"] {
                margin-bottom: 15px;
            }

            .form-container label {
                display: inline-block;
                float: left;
                width: 100px;
            }

            .form-container button {
                display: block;
                padding: 5px 10px;
                background-color: #8daf15;
                color: #fff;
                border: none;
            }

            .form-container .link-to-product-details {
                margin-top: 20px;
                display: inline-block;
            }
        </style>

    </head>
    <body>

        <div class="form-container">
            <h2>Add a product</h2>

            <div class="messages">
                <?php
                if (isset($errors)) {
                    echo implode('<br/>', $errors);
                } elseif ($productSaved) {
                    echo 'The product details were successfully saved.';
                }
                ?>
            </div>

            <form action="addProduct.php" method="post" enctype="multipart/form-data">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo isset($productName) ? $productName : ''; ?>">

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" min="0" value="<?php echo isset($productQuantity) ? $productQuantity : '0'; ?>">

                <label for="description">Description</label>
                <input type="text" id="description" name="description" value="<?php echo isset($productDescription) ? $productDescription : ''; ?>">

                <label for="file">Images</label>
                <input type="file" id="file" name="file[]" multiple>

                <div id="tool_status">
                            <label id="Tstatus_Label" for="Tstatus">
                                حالة المنتج:
                            </label></br>

                            <input type="radio" id="Tstatus1" name="Tstatus" value="جديد" required>
                            <label for="Tstatus1">جديد</label><br>

                            <input type="radio" id="Tstatus2" name="Tstatus" value="مستخدم">
                            <label for="Tstatus2">مستخدم</label></br></br>

                        </div>



                        <div id="tool_city">
                            <label id="Tcity_Label" for="Tcity">
                                مدينة البائع:
                            </label></br>

                            <style>
                                .dropdown {
                                    background-color: #f1f1f1;
                                    color: black;

                                    font-size: 18px;
                                    margin-top: 3%;
                                    margin-right: 15%;
                                    border-radius: 10px;

                                    padding-right: 5%;

                                    height: 40px;
                                    width: 200px;
                                    border: none;
                                }
                            </style>

                            <div class="dropdownMenu">
                                <select class="dropdown" id="Tcity" name="Tcity" required>
                                    <option value="" disabled selected>اختر مدينتك</option>
                                    <option value="جدة">جدة</option>
                                    <option value="الرياض">الرياض</option>
                                    <option value="مكة">مكة</option>
                                    <option value="أبها">ابها</option>
                                    <option value="تبوك">تبوك</option>
                                </select>
                            </div>
                            </br></br>
                        </div>


                        <div id="leftSide" style="display: inline-table; width: 30%; margin-right: 5%;">
                        <div id="tool_section">
                            <label id="Tsection_Label" for="Tsection">
                                قسم المنتج:
                            </label></br>

                            <div class="dropdownMenu">
                                <select class="dropdown" id="Tsection" name="Tsection"
                                    onchange="changingList(), addTextBox()" required>
                                    <option value="" disabled selected>اختر قسم المنتج</option>
                                    <option value="الحياكة والتطريز">الحياكة والتطريز</option>
                                    <option value="اللوحات">اللوحات</option>
                                    <option value="الخزف والزجاج">الخزف والزجاج</option>
                                    <option value="غير ذلك">غير ذالك</option>
                                </select>
                            </div>
                        </div>

                        </br></br>

                        <div id="tool_type">
                            <label id="Ttype_Label" for="Ttype">
                                نوع المنتج:
                            </label></br>

                            <div class="dropdownMenu">
                                <select class="dropdown" id="Ttype" name="Ttype" onchange="OtherOption()" required>
                                    <option value="" disabled selected>اختر نوع المنتج</option>
                                </select>
                            </div>
                            <br>
                            <script>
                                var tools = {};
                                tools['الحياكة والتطريز'] = [
                                    'ابر',
                                    'خيوط',
                                    'اقمشة',
                                    'طارة',
                                    'آخر'];

                                tools['اللوحات'] = [
                                    'فرش',
                                    'مزيل الوان',
                                    'الوان',
                                    'لوحة الوان',
                                    'آخر'];

                                tools['الخزف والزجاج'] = [
                                    'ادوات نحت',
                                    'صحن دوار',
                                    'قوالب تشكيل',
                                    'اخر'];

                                tools['غير ذلك'] = [
                                    'ابر',
                                    'خيوط',
                                    'اقمشة',
                                    'طارة',
                                    'فرش',
                                    'مزيل الوان',
                                    'الوان',
                                    'لوحة الوان',
                                    'ادوات نحت',
                                    'صحن دوار',
                                    'قوالب تشكيل',
                                    'آخر'
                                ]

                                function changingList() {
                                    var section = document.getElementById("Tsection");
                                    var type = document.getElementById("Ttype");

                                    var toolTypes = section.options[section.selectedIndex].value;

                                    //type.options.length = 1;

                                    while (type.options.length) {
                                        type.remove(0);
                                    }
                                    var addTool = tools[toolTypes];

                                    type.options.add(new Option('اختر نوع المنتج'));
                                    type.options[0].disabled = true;

                                    if (addTool) {
                                        var i;

                                        for (i = 0; i < addTool.length; i++) {
                                            var newTool = new Option(addTool[i], i);
                                            type.options.add(newTool);
                                            newTool.setAttribute("value", addTool[i]);
                                            //console.log(newTool);
                                        }
                                    }
                                }
                            </script>


                         <div id="tool_contact">
                                <label id="Tcontact_Label" for="Tcontact">
                                    طريقة التواصل:
                                </label></br>
                                <div id="checkBoxContact" name="Tcontact" >
                                    <input type="checkbox" id="Tcontact1" name="Tcontact" value="email"
                                        onclick="ContactTextBox()">
                                    <label for="Tcontact1">بريد الكتروني</label><br>

                                    <input style="margin-right: 25%; width: 400px;" type="email" id="Temail"
                                        name="Temail" placeholder="YourEmail@email.com" hidden="true"
                                        ><br><br>

                                    <input type="checkbox" id="Tcontact2" name="Tcontact" value="phone"
                                        onclick="ContactTextBox()">
                                    <label for="Tprice1">جوال</label><br>

                                    <input style="margin-right: 25%; width: 400px;" type="tel" id="Tphone"
                                        name="Tphone" placeholder="55-5555-555" pattern="[0-5]{2}-[0-9]{4}-[0-9]{3}"
                                        hidden="true" >
                                    <br></br>

                                    <script>
                                        function ContactTextBox() {
                                            var byEmail = document.getElementById("Tcontact1");
                                            var byPhone = document.getElementById("Tcontact2");

                                            var email = document.getElementById("Temail");
                                            var phone = document.getElementById("Tphone");

                                            //email.disabled = byEmail.checked ? false : true;

                                            if (byEmail.checked) {
                                                //phone.disabled;
                                                email.hidden = false;
                                                email.focus();
                                            } else {
                                                email.hidden = true;
                                            }

                                            if (byPhone.checked) {
                                                phone.hidden = false;
                                                phone.focus();
                                            } else {
                                                phone.hidden = true;
                                            }
                                            
                                            

                                        }
                                    </script>
                                </div>
                                    </div>
                            


                                    <?php  if (isset($_SESSION['username'])) : ?>
       
       <input value="<?php echo $_SESSION['username']; ?>" type="hidden" id="id" name="id"  >

<?php endif ?>

                

                <button type="submit" id="submit" name="submit" class="button">
                    Submit
                </button>
            </form>

            <?php
            if ($productSaved) {
                ?>
                <a href="getProduct.php?id=<?php echo $lastInsertId; ?>" class="link-to-product-details">
                    Click me to see the saved product details in <b>getProduct.php</b> (product id: <b><?php echo $lastInsertId; ?></b>)
                </a>
                <?php
            }
            ?>


        </div>

    </body>
</html>