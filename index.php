
<!-- INCLUDE FILE TRONG PHP  -->
<?php 

    $globalVar = ""; //biến toàn cục
    function tong(){
        // các biến đc khai báo trong hàm đều là biến cục bộ
        $t = 0;
        global $globalVar;
        $globalVar .= 'abc';
        // muốn dùng các biến bên ngoài phải sử dụng global;
        $mang = func_get_args(); // cách lấy ra tất cả các tham số truyền vào

        foreach($mang as $value){
            $t .= $value;
        }
        return $t;
    }
    tong(1,3,5,7,8,4,5,'sá');
    // biến siêu toàn cục là biến lấy thông tin từ server
    $abs_path = $_SERVER['SCRIPT_FILENAME'];
    $script_name = $_SERVER['SCRIPT_NAME'];
    $server_hot = $_SERVER['HTTP_HOST'];

    // 1 số biến siêu toàn cục
    
    echo '<pre>';
    print_r($_GET);
    echo '</pre>';
    echo '<pre>';
    print_r($_POST);
    print_r($_FILES);
?>

<div class="container">
    <form>
        <div class="mb-3 row">
            <label for="inputName" class="col-4 col-form-label">Name</label>
            <div class="col-8">
                <input type="file" class="form-control" name="upload" id="inputName" placeholder="Name">
            </div>
        </div>
        <div class="mb-3 row">
            <div class="offset-sm-4 col-sm-8">
                <button type="submit" class="btn btn-primary">Action</button>
            </div>
        </div>
    </form>
</div>