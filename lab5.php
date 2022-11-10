<?php
    $image = '';
    if(!empty($_POST['image'])){
       $image = $_POST['image'];
    };
?>
<?php
    $content = '';
    $color = 'black';
    $bg = 'white';
    $width = 'auto';
    if(!empty($_POST['text'])){
        $color = $_POST['text'];
        $bg = $_POST['background'];
        $width = $_POST['width'];
        $content = $_POST['content'];
    }
    $nextBirthday = '';
    if(!empty($_POST['born'])){
        $born = $_POST['born'];
        $year = substr($born,0,4);
        $mon_day = substr($born,5,5);
        if($year % 4 == 0 && $mon_day == '02-29'){
            if($year % 100 == 0 && $year % 400 != 0){
                $nextBirthday = str_replace($year,$year+1,$born);    
            }else{
                $nextBirthday = str_replace($year,$year+4,$born);  
            }
        }else{
            $nextBirthday = str_replace($year,$year+1,$born);  
        }
    }

    $days31 = [1,3,5,7,8,10,12];
    $days30 = [4,6,9,11];
    $soNgay = '';
    
    if(!empty($_POST['month'])){
        $date = $_POST['month'];
        $year2 = substr($date,0,4);
        $thang = substr($date,5,2);
        if($year2 % 4 == 0 && $thang == 2){
            if($year2 % 100 == 0 && $year2 % 400 != 0){
                $soNgay = 28;    
            }else{
                $soNgay = 29;   
            }
        }else{
            if(in_array($thang,$days30)){
                $soNgay = 30;
            }elseif(in_array($thang,$days31)){
                $soNgay = 31;
            }elseif($thang = 2){
                $soNgay = 28;
            }
        }
    }
    $err = null;
    $errEmail = null;
    $errPhone = null;
    $errFB = null;
    if(isset($_GET['ten2'])){ 
        if(is_string($_GET['ten2'])){
            $ten2 = $_GET['ten2'];
            if(strlen($ten2) > 30 && !empty($ten2)){
                $err = 'Tên của bạn vượt quá 30 ký tự';
            }elseif(empty($ten2)){
                $err = 'Bạn phải điền tên của mình';
            }
        }
        $email2 = $_GET['email2'];
        if(empty($email2)){
            $errEmail = 'Địa chỉ email không được để trống';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errEmail = 'Địa chỉ email không đúng định dạng';
        }
    
        
        $phone2 = $_GET['phone2'];
        $firstNumber = substr($phone2,0,2);
        $checkNumberic = true;
        for($i=0; $i < 10; $i++){
            if(!is_numeric($phone2[$i])){
                $checkNumberic = false;
                break;
            }
        }
        if(empty($phone2)){
            $errPhone = 'Số điện thoại của bạn không được để trống';
        }elseif(!$checkNumberic || strlen($phone2) != 10 || $firstNumber == '09' || $firstNumber == '03'){
            $errPhone = 'Số điện thoại của bạn không đúng định dạng';
        }

        
        $fb = $_GET['facebook'];
        if(empty($fb)){
            $errFB = 'Link Facebook của bạn không được để trống';
        }elseif(!filter_var($email, FILTER_VALIDATE_URL)){
            $errFB = 'Đường dẫn URL không đúng định dạng';
        }
        
    }

    $err2 = [];

    $name3 = '';
    $price3 = '';
    $sale_price3 = '';
    if(isset($_POST['name3']) || isset($_POST['price3']) || isset($_POST['sale_price3'])){
        $name3 = $_POST['name3'];
        $price3 = $_POST['price3'];
        $sale_price3 = $_POST['sale_price3'];
        if(empty($name3)){
            $err2['nameErr'] = 'Bạn chưa nhập tên';
        }
        if(empty($price3)){
            $err2['priceErr']= 'Bạn chưa nhập giá gốc';
        }
        if(empty($sale_price3)){
            $err2['saleErr']= 'Bạn chưa nhập giá khuyến mãi';
        }
        if($price3 < $sale_price3){
            $err2['moreErr']= 'Gía khuyến mãi của bạn cao hơn giá gốc';
        }
        if(!empty($_FILES['upload']['tmp_name'])){
            $file = $_FILES['upload']; // cố định mảng file cần truy cập vào 1 biến để lấy thông tin sau cho nhanh
            $tmp_name = $file['tmp_name'];
            $nameImage = $file['name'];
            move_uploaded_file($tmp_name, 'images/'.$nameImage); // di chuyển mảng file vào thư mục ban đầu vào thư mục mình muốn (địa chỉ gốc lấy từ tmp_name, thư mục muốn chuyển)
        }else{
            $err2[] = 'Bạn chưa nhập đường dẫn ảnh';
        }
    }
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <h1 class="text-center mt-5">FORM DEMO</h1>
        <div class="row">
            <div class="col-md-7">
                <form method="POST">
                    <select name="image" style="padding: 7px 100px">
                        <option value="https://kynguyenlamdep.com/wp-content/uploads/2022/06/anh-gai-xinh-cuc-dep.jpg">
                            Ảnh 1</option>
                        <option value="https://taimienphi.vn/tmp/cf/aut/anh-gai-xinh-1.jpg">Ảnh 2</option>
                        <option
                            value="https://2.bp.blogspot.com/-gnXUMwRHkaI/WE1VCAktNhI/AAAAAAAAjfs/CZk6jUipKXgvOKc821Rnz-fwXT0QhLEuACEw/s1600/15085502_591915637681021_5420424684372040797_n.jpg">
                            Ảnh 3</option>
                        <option value="https://khoinguonsangtao.vn/wp-content/uploads/2022/08/hinh-nen-gai-xinh.jpg">Ảnh
                            4</option>
                        <option value="https://kenh14cdn.com/thumb_w/660/2020/5/28/0-1590653959375414280410.jpg">Ảnh 5
                        </option>
                    </select>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
            <div class="col-md-5">
                <img class="card-img" src="<?= $image ?>" alt="">
            </div>
        </div>
    </div>
    <div class="container">
        <h1 class="text-center mt-5">Bài 2</h1>
        <form method="POST">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Màu nền</label>
                        <input class="form-control fs-1" style="height: 40px !important;" type="color"
                            name="background">
                    </div>
                    <div class="form-group mt-2">
                        <label width="200px" for="">Màu Chữ</label>
                        <input class="form-control fs-1 d-block" style="height: 40px !important;" type="color"
                            name="text">
                    </div>
                    <div class="form-group mt-2">
                        <label width="200px" for="">Chiều rộng</label>
                        <input class="form-control  py-2 d-block" type="text" name="width">
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                <div class="col-md-8">
                    <textarea name="content" cols="100" rows="5"></textarea>
                    <br>
                    <p class="d-inline-block"
                        style="color: <?= $color ?>; background-color: <?= $bg ?>; width: <?= $width ?>px !important">
                        <?= $content ?></p>
                </div>
            </div>
        </form>
        <h1 class="text-center mt-5">Bài 3</h1>
        <div class="col-5 mx-auto">
            <form method="post">
                <div class="form-group">
                    <label for="">Nhập ngày sinh của bạn</label>
                    <input type="date" name="born" class="form-control" placeholder="DD/MM/YYYY"
                        aria-describedby="helpId">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <h2 class="text-center">Sinh nhật năm sau của bạn là: <br><?= $nextBirthday ?></h2>
        </div>

        <h1 class="text-center mt-5">Bài 4</h1>
        <div class="col-5 mx-auto">
            <form method="post">
                <div class="form-group">
                    <label for="">Nhập đây ngày bạn muốn</label>
                    <input type="date" name="month" class="form-control" placeholder="Month" aria-describedby="helpId">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <?php if(!empty($_POST['month'])) : ?>
            <h2 class="text-center">Số ngày trong tháng <?= $thang; ?> của <?= $year2; ?> là <?= $soNgay; ?></h2>
            <?php endif ?>
        </div>

        <h1 class="text-center mt-5">Bài 1,3.2</h1>
        <div class="col-5 mx-auto">

            <form method="get">
                <div class="form-group">
                    <label for="">Tên</label>
                    <input type="text" name="ten2" class="form-control" placeholder="Nhập tên của bạn"
                        aria-describedby="helpId">
                    <?php if(is_string($err)) : ?>
                    <span class="text-danger">Error: <?= $err ?></span>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email2" class="form-control" placeholder="Nhập email của bạn"
                        aria-describedby="helpId">
                    <?php if(is_string($errEmail)) : ?>
                    <span class="text-danger">Error: <?= $errEmail ?></span>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" name="phone2" class="form-control" placeholder="Nhập số điện thoại của bạn"
                        aria-describedby="helpId">
                    <?php if(is_string($errPhone)) : ?>
                    <span class="text-danger">Error: <?= $errPhone ?></span>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="">Facebook</label>
                    <input type="text" name="facebook" class="form-control" placeholder="Nhập link facebook của bạn"
                        aria-describedby="helpId">
                    <?php if(is_string($errFB)) : ?>
                    <span class="text-danger">Error: <?= $errFB ?></span>
                    <?php endif ?>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <h1 class="text-center mt-5">Bài 2.2</h1>
        <div class="col-5 mx-auto">
            <?php if(count($err2)) : ?>
            <div class="alert alert-danger">
                <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
                <?php foreach($err2 as $err) : ?>
                <p>Lỗi: <?php echo $err ;?> </p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name3" class="form-control" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="">Price</label>
                    <input type="text" name="price3" class="form-control" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="">Sale Price</label>
                    <input type="text" name="sale_price3" class="form-control" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" class="form-control" name="upload" id="image" placeholder="Image">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
            <?php if(isset($_POST['name3'])) : ?>
            <div class="card">
                <img class="card-img-top" src="images/<?= $nameImage ?>" alt="Title">
                <div class="card-body">
                    <h4 class="card-title text-center"><?= $name3 ?></h4>
                    <p class="card-text text-center">Gía gốc: <?= $price3 ?></p>
                    <p class="card-text text-center fw-bold">Gía khuyến mãi: <?= $sale_price3 ?></p>
                </div>
            </div>
            <?php endif ?>

        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>