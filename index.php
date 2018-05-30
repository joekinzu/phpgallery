<!-- file upload part -->
<form enctype="multipart/form-data" action="?" method="post">
  Upload: <input type="file" name="myfile" />
  <input type="submit" value="Send" name="Upload"/>
</form>
<hr>
<?php
// image resize function
  function img_resize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 100){
    if(!file_exists($src))return false;
    $size = getimagesize($src);
    if($size === false) return false;
    $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
    $icfunc = "imagecreatefrom" . $format;
    if (!function_exists($icfunc)) return false;
    $x_ratio = $width / $size[0];
    $y_ratio = $height / $size[1];
    $ratio       = min($x_ratio, $y_ratio);
    $use_x_ratio = ($x_ratio == $ratio);
    $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
    $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
    $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
    $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
    $isrc = $icfunc($src);
    $idest = imagecreatetruecolor($width, $height);
    imagefill($idest, 0, 0, $rgb);
    imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);
    imagejpeg($idest, $dest, $quality);
    imagedestroy($isrc);
    imagedestroy($idest);
    return true;
  }
// file upload
  if (isset($_POST['Upload'])){
    $uploadOk = 1;
    $error='';
    $uploaddir = 'img/';
    $destination = $uploaddir.$_FILES['myfile']['name'];
    $imageFileType = strtolower(pathinfo($destination,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
      $uploadOk = 0;
      $error = "Bad file type <br>";}
    if ($_FILES["myfile"]["size"] > 1000000) {
      $uploadOk = 0;
      $error = "File size too large <br>";}   
    if($uploadOk!=0){
    if(move_uploaded_file($_FILES['myfile']['tmp_name'],$destination)){
      print "Success <br>";
      img_resize('img/'.$_FILES['myfile']['name'],'img1/'.$_FILES['myfile']['name'], 200, 200);
    }}else{
      print $error;
      print_r($_FILES);}
  }
?>
<!-- gallery part -->
<table>
<tr>
  <th>Name</th>
  <th>Image</th>
</tr>
<?php
//pics folders
  $files = glob("img1/*.*");
  $bfiles = glob("img/*.*");
  $file_types = array('jpg','jpeg','png');
  for($i = 0; $i<count($files); $i++){
    // retrieve filename and extension
    $image = $files[$i];
    $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    for($j = 0; $j<count($bfiles); $j++){
      // retrieve filename and extension
      $bimage = $bfiles[$j];
      $bext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
      // draw pics
      if(basename($image)==basename($bimage) && in_array($ext, $file_types) && in_array($bext, $file_types)){
        echo "<tr><td>";
        echo basename($image);
        echo "</td><td>";
        echo '<a href="'.$bimage.'"><img src="'.$image.'"alt="Random image", width=100px, height=100px/><br></a>';
        echo "</td></tr>";
      } 
    }
  }
?>
</table>