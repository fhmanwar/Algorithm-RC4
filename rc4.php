<?php
function KSA($k){  //proses KSA key scheduling algoritm
  //isi array s
  global $s;
  $s = array();
  for($i=0;$i<256;$i++){
    //ambil nilai ASCII dari tiap karakter password
    // $key[$i]=ord($k[$i % strlen($k)]);
    $s[$i] = $i;//isi array s 0 s/d 255
   }
   //masukan password ke array key secara berulang sampai penuh

   //permutasi/pengacakan isi array s
   $j = 0;
   $i = 0;
  for($i=0;$i<256;$i++){
    $j = ( $j + $s[$i] + ord($k[$i % strlen($k)]) ) % 256;

    //swap
    $temp = $s[$i];
    $s[$i] = $s[$j];
    $s[$j] = $temp;
  }
}

function PRGA($text){ //pseudo-random generation algorithm(PRGA)
  global $s;
  $x=0;$y=0;
  $hasil='';
  for($i=1;$i<= strlen($text);$i++){
    $x = ($x+1) % 256;
    $y = ($y+$s[$x]) % 256;

    //swap
    $temp = $s[$x];
    $s[$x] = $s[$y];
    $s[$y] = $temp;
    /*proses XOR antara text dengan kunci
    dengan $text sebagai text
    dan $s sebagai kunci*/
    $hasil = ($text^$s[($s[$x] + $s[$y]) % 256]) % 256;
    return $hasil;
  }
}

  $isi = 'Hello world, welcome to my world';
  $key = 'asdqwe123';
  $hsl_enc = '';
  $hsl_dec='';
  $wew = '';

  echo 'panjang => "'.$isi.'" = ';
  echo strlen($isi);
  echo '<br>';
  echo 'nilai ascii : ';
  for ($i=0; $i < strlen($isi) ; $i++) {
    $a[$i] = ord($isi[$i]);/*ord untuk mengubah nilai ascii to decimal */
    $b[$i] = chr($a[$i]);/*chr untuk mengembalikan nilai decimal to ascii*/

  }
  echo '<br>';
  for ($i=0; $i < strlen($isi) ; $i++) {
    echo $a[$i].' = '.$b[$i].'<br>';
  }
  echo '<br>';

  KSA($key);
  // Algoritma Enkripsi RC4
  for($i=0;$i<strlen($isi);$i++){
   $x[$i]=ord($isi[$i]); /*rubah ASCII ke desimal*/
   $enc[$i]=PRGA($x[$i]); /*proses enkripsi RC4*/
   $chr_enc[$i]=chr($enc[$i]);

   $hsl_enc = $hsl_enc . $chr_enc[$i];
   $wew = $wew . $enc[$i].', ';
  }

  KSA($key);
  // Algoritma Dekripsi RC4
  for($i=0;$i<strlen($hsl_enc);$i++){
    $y[$i]=ord($chr_enc[$i]); /*rubah ASCII ke desimal*/
    $dec[$i]=PRGA($y[$i]); /*proses dekripsi RC4*/
    $chr_dec[$i]=chr($dec[$i]); /*rubah desimal ke ASCII*/

    $hsl_dec = $hsl_dec . $chr_dec[$i];
	}


  echo '<br>';
  echo $wew;
  echo '<br>';
  echo strlen($hsl_enc);
  echo '<br>';
  echo $hsl_enc;
  echo '<br>';
  echo $hsl_dec;
?>
