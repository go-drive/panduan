<?php

function get_remember($cookie_token) {
    session_start();
    global $conn;
    
    $data = $conn->query("SELECT * FROM users WHERE cookie_token='".$cookie_token."'");
    $hasil = $data->fetch_assoc();
    
    if($data->num_rows > 0) {
         $_SESSION['user'] = $hasil;
    }
   
}

function tanggal_indo($tanggal)
{
    $bulan = array (1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}

function filter($data){

$filter = stripslashes(strip_tags(htmlspecialchars(htmlentities($data,ENT_QUOTES))));

return $filter;

}

function acak($length) {
	$str = "";
	$karakter = array_merge(range('A','Z'), range('a','z'), range('1','9'));
	$max_karakter = count($karakter) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max_karakter);
		$str .= $karakter[$rand];
	}
	return $str;
}

function acak_nomor($length) {
	$str = "";
	$karakter = array_merge(range('1','9'));
	$max_karakter = count($karakter) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max_karakter);
		$str .= $karakter[$rand];
	}
	return $str;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'Tahun',
        'm' => 'Bulan',
        'w' => 'Minggu',
        'd' => 'Hari',
        'h' => 'Jam',
        'i' => 'Menit',
        's' => 'Detik',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' Yang Lalu' : 'Baru Saja';
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } elseif (getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } elseif (getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
}

function get_client_browser() {
    $browser = '';
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
        $browser = 'Netscape';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
        $browser = 'Firefox';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
        $browser = 'Chrome';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
        $browser = 'Opera';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
        $browser = 'Internet Explorer';
    else
        $browser = 'Other';
    return $browser;
}

function validate_date($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') == $date;
}

function infojson($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);
                return $data;
}

function Show($tabel, $limit) {
        global $conn;
        $CallData = mysqli_query($conn, "SELECT * FROM ".$tabel." WHERE ".$limit);
        $ThisData = mysqli_fetch_assoc($CallData);
        return $ThisData;
}

function followers_count($data){
    $id = file_get_contents("https://instagram.com/web/search/topsearch/?query=".$data);
    $id = json_decode($id, true);
    $count = $id['users'][0]['user']['follower_count'];
    return $count;
}

function likes_count($data){
    $id = file_get_contents("".$data."?&__a=1");
    $id = json_decode($id, true);
    $count = $id['graphql']['shortcode_media']['edge_media_preview_like']['count'];
    return $count;
}

function views_count($data){
    $id = file_get_contents("".$data."?&__a=1");
    $id = json_decode($id, true);
    $count = $id['graphql']['shortcode_media']['video_view_count'];
    return $count;
}

$result = json_decode(file_get_contents('https://demo.elyng.com//api/validate/host/'.$_SERVER['SERVER_NAME'].'/1'), true);
if($result['status'] != 200) {
$html = "<title>Website Dikunci</title>
<meta name='viewport' content='width=device-width, initial-scale=1' />
<link rel='shortcut icon' href='https://demo.elyng.com/assets/img/teamid.png'>
<link rel='stylesheet' href='https://demo.elyng.com/assets/css/license.css'>
</head>
<body>
	<div class='container'>
		<div class='media'>
			<h3>Alamat Website</h3>
			<h1>Konfirmasi Alamat Website melalui <a href='https://wa.me/6285896630965' style='text-decoration:none;color:#ffffff'>WhatsApp</a></h1>
			<p>belum memiliki izin untuk menggunakan Layanan ini</p>
			<p>Best Service is Our Goal <a href='https://team-id.elyng.com/' style='text-decoration:none;color:#ffffff'>Team ID</a></p>
		</div>
		<div class='overlay'>
			<div id='particle-background' class='particle-background'><canvas class='particles-js-canvas-el' style='width: 100%; height: 100%;' width='1366' height='683'></canvas></div>
		</div>
	</div>
	<script src='https://demo.elyng.com/assets/js/license.js'></script>
</body>
</html>
";
$search = '<%returnmessage%>';
$replace = $result['message'];
$html = str_replace($search, $replace, $html);
die( $html );
}

?>
