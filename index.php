<?php
// require_once 'config.php';
// require_once 'classes/Database.php';
// require_once 'classes/User.php';
// require_once 'classes/Pesanan.php';
// require_once 'classes/Produk.php';

// ob_start();


// if (isset($_GET['url'])) {
//     $url = rtrim($_GET['url'], '/');
//     $url = filter_var($url, FILTER_SANITIZE_URL);
//     $url = explode('/', $url);
// } else {
//     $url[0] = 'home';
// }

// function displayPage($page, $data = [])
// {
//     $dir = 'pages/';
//     $file = $page[0];
//     $subpage = isset($page[1]) ? $page[1] : null;

//     if ($page[0] == 'admin' && $subpage != null) {
//         $dir = 'pages/admin/';
//         $file = $subpage;
//     }

//     if (file_exists($dir . $file . '.php')) {

//         // include 'templates/header.php';
//         include $dir . $file . '.php';
//         // include 'templates/footer.php';

//         // Kirim data ke page yang dimuat
//         if (!empty($data)) {
//             foreach ($data as $key => $value) {
//                 $$key = $value;
//             }
//         }
//     } else {
//         include 'pages/404.php';
//     }
// }

// $dir_css = $url[0] == 'admin' ? 'pages/admin/assets/css/' : 'pages/assets/css/';
// $css = isset($url[1]) ? $url[1] : $url[0];

// $data = array(
//     'title' => $url[0],
//     'css' => $dir_css . $css . '.css',
// );

// displayPage($url, $data);


// ob_flush();

if (!session_id()) session_start();
require_once 'app/init.php';
$app = new App();
