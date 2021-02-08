<?php

<<<<<<< Updated upstream
$profile_id = $_GET['id'];

if (!empty($profile_id)) {
	/*ladda templatefilen för profil*/
	echo "string";
} else {
	/*ifall inget id bara redirecta till main filen*/
	header('location: /');
}
=======
error_reporting(E_ERROR | E_WARNING | E_PARSE);

/*Edit:
login.php, la till variabel för sessions userid*/

session_start();
require 'config.php';
$id = $_SESSION['userid'];

$thisUser      = getUserData($pdo, $id);
$userImages    = getUserImages($pdo, $id);

$p_img          = $_FILES["image"];
$p_img_name     = $_FILES['image']['name'];
$bio            = $_POST['bio'];
$fname          = $_POST['fname'];
$lname          = $_POST['lname'];
$email          = $_POST['email'];
$password       = $_POST['password'];
$post_content   = $_POST['post_content'];

if(isset($_POST['submit'])) {
    updateUser($pdo, $id, $email, $p_img, $bio, $p_img_name);
}

if(isset($_POST['post_content'])) {
    newPost($pdo, $id, $p_img_name, $post_content);
}

if(isset($_POST['change_pw'])) {
    updateUserPassword($pdo, $id, $password);
}
if (isset($_GET['updated'])) {
  isUpdated();
}

function isUpdated() {
  echo '<div class="container"><div class="alert alert-success timer" role="alert">Successfully updated account details!</div></div>';
}
function isUpdatedPassword() {
  echo '<div class="container"><div class="alert alert-success timer" role="alert">Successfully updated password!</div></div>';
}
function isNewPost() {
  echo '<div class="container"><div class="alert alert-success timer" role="alert">Your post has been published.</div></div>';
}

function getUserData($pdo, $id) {
    $statement = $pdo->prepare('SELECT * FROM users WHERE id ='.$id.'');
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

// ville sortera denna efter datum, dvs senaste går högst men där finns duplikation av tabell namn för både images & users.
function getUserImages($pdo, $id) {
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT filename FROM users JOIN images ON users.id = images.user_id WHERE users.id ="'.$id.'" ORDER BY filename';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function newPost($pdo, $id, $p_img_name, $post_content) {
    $sql = "INSERT INTO images (user_id, filename, text) VALUES ('$id', '$p_img_name', '$post_content')";
    $pdo->exec($sql);
    updateProfileImage($p_img_name);
    header('location: profile.php');
}

function updateUser($pdo, $id, $email, $p_img, $bio, $p_img_name, $fname, $lname) {
    $sql = "UPDATE users SET email=:email, bio=:bio, fname=:fname, lname=:lname, profile_img=:p_img WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":fname", $fname, PDO::PARAM_STR);
    $statement->bindValue(":lname", $lname, PDO::PARAM_STR);
    $statement->bindValue(":email", $email, PDO::PARAM_STR);
    $statement->bindValue(":p_img", "images/".$p_img_name, PDO::PARAM_STR);
    $statement->bindValue(":bio", $bio, PDO::PARAM_STR);
    $statement->bindValue(":id", $id, PDO::PARAM_STR);
    $statement->execute();
    if (isset($_FILES['image'])) {
      updateProfileImage($p_img);
    }
    header('location: profile.php?updated');
}

function updateUserPassword($pdo, $id, $password) {
    $sql = 'UPDATE users SET password=:password WHERE id ='.$id.'';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":password", password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $statement->execute();
    isUpdatedPassword();
}

function updateProfileImage($p_img) {
   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      $extensions= array("jpeg","jpg","png");
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"images/".$file_name);
      }else{
         print_r($errors);
      }
   }
}

include 'templates/header.php';
?>
<!-- inkluda i headern -->
<script src="https://kit.fontawesome.com/a69a6f4641.js" crossorigin="anonymous"></script>


<!-- lägg i style.css -->
<style type="text/css" media="screen">
.image-area.mt-4.mb-4{display:none}input#upload{display:none}
.alert {
    margin-top: 40px;
    margin-bottom: 30px;
}
.profile-header {
    margin: 50px 0 20px 0;
}
button.close {
    font-size: 28px;
}

.modal
</style>

<div class="row profile-header">
    <div class="col-4 pimg_holder d-inline-block">
      <div class="profile-images">
        <?php if(!empty($thisUser['0']['profile_img'])) {
          echo "<img class='preview_profile_image' src='".$thisUser['0']['profile_img']."' style='border-radius:50%;'>";
        } else {
          echo "<img class='preview_profile_image' src='images/default.png' style='border-radius:50%;'>";
        }
        ?>
      </div>
    </div>

    <div class="col-8 general_info d-inline-block" style="position:relative;top:35px;">
      <h3><?php echo $thisUser['0']['username']; ?></h3>      
      <p class="userinfo">
      <?php echo $thisUser['0']['fname'] . " " . $thisUser['0']['lname'] ?>
      </p>
      <p class="userbio">
      <?php echo $thisUser['0']['bio'];?>
      </p>

        <?php if (!empty($userImages)) {
          echo "<button type='button' class='btn btn-primary mt-2' data-toggle='modal' data-target='#exampleModal'><i class='fas fa-camera-retro'> </i> Create new post</button>";
        }?>
    </div>
</div>

<!-- accordion -->
<div id="accordion">

  <div class="card">
    <div class="card-header" id="acc_settings">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#settings" aria-expanded="true" aria-controls="settings">
          <i class='fad fa-cog'></i> Settings
        </button>
      </h5>
    </div>
    <div id="settings" class="collapse" aria-labelledby="acc_settings" data-parent="#accordion">
      <div class="card-body">
        <div class="col-12 p-4">
          <!-- form -->
          <form enctype="multipart/form-data" action="profile.php" method="post">
            <div class="upload_img mb-3">
                <div class="current_p_img">
                  <?php if(!empty($thisUser['profile_img'])) {
                      echo '<div class="alert alert-danger" role="alert">No profile picture chosen yet, would you like one?</div>';
                  }?>
                </div>
            </div>
            <div class="form-group mb-5">
              <label>New profile image?</label>
              <input name="image" type="file" class="form-control-file" id="profile_img">
            </div>
            <div class="row mb-2">
              <div class="col">
                <label>First name</label>
                <input type="text" name="fname" value="<?php echo $thisUser['0']['fname'];?>" class="form-control" placeholder="First name">
              </div>
              <div class="col">
                <label>Last name</label>
                <input type="text" name="lname" value="<?php echo $thisUser['0']['lname'];?>" class="form-control" placeholder="Last name">
              </div>
            </div>
            <div class="form-group">
              <label for="firstName">About me</label>
              <textarea type="text" rows="3" name="bio" class="form-control" id="bio"><?php echo $thisUser['0']['bio'];?></textarea>
            </div>
            <div class="form-group">
              <label for="email">Your email address</label>
              <input type="text" name="email" class="form-control" id="email" value="<?php echo $thisUser['0']['email'];?>" placeholder="<?php echo $thisUser['0']['email'];?>">
            </div>
            <button class="btn btn-success mt-3" name="submit" type="submit">Save settings</button>
          </form>
         </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="acc_password">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#password" aria-expanded="false" aria-controls="password">
          <i class="fad fa-key"></i> Password
        </button>
      </h5>
    </div>
    <div id="password" class="collapse" aria-labelledby="acc_password" data-parent="#accordion">
      <div class="card-body">
        <div class="col-12 p-4">
          <!-- form -->
          <form action="profile.php" method="post">

            <div class="form-group">
              <label for="password">Password</label>
              <input type="text" name="password" class="form-control" id="password" value="" placeholder="Enter the new password">
            </div> 

            <button class="btn btn-success mt-3" name="change_pw" type="submit">Save new password</button>
          </form>
         </div>
      </div>
    </div>
  </div>
</div>

<!-- post loop -->
<div class="row">
  <div class="col-12">
    <h4 class="mt-4">Posts</h4>
      <hr>
      <div class="row">
        <?php if (empty($userImages)) {
          echo "<div class='col-12 mt-5 mb-5 text-center'><h5>You have not posted any images yet.</h5><button type='button' class='btn btn-primary mt-2' data-toggle='modal' data-target='#exampleModal'>Create your first post!</button></div>";
        } else
          foreach ($userImages as $image) {
            echo "<div class='col-4'>
                <div class='profile-images'>
                    <img src='images/".$image['filename']."' style='border-radius:5px;'>
                </div>
            </div>";
          }
        ?>
      </div>

  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form enctype="multipart/form-data" action="profile.php" method="post">
      <div class="modal-body">

          <!-- Uploaded image area-->
          <div id="prev_post_img" class="image-area mt-4 mb-4"><img id="imageResult" src="#" alt="" class="img-fluid rounded mx-auto d-block"></div>

          <!-- Upload image input-->
          <div class="input-group mb-3 px-2 py-2 bg-white">
              <input id="upload" name="image" type="file" onchange="readURL(this);" class="form-control border-0">
              <div class="input-group-append">
                  <label for="upload" class="btn btn-light m-0 px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small id="btn_img_upload" class="text-uppercase font-weight-bold text-muted">Choose image</small></label>
              </div>
          </div>

          <div class="form-group">
            <textarea name="post_content" class="form-control" id="post_content" rows="3" placeholder="Your text.." required></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button name="upload_post" type="submit" class="btn btn-primary">Upload</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script type="text/javascript">

setTimeout(function() {
    $('.timer').fadeOut('slow');
}, 5000);

function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {$('#imageResult').attr('src', e.target.result);};
        reader.readAsDataURL(input.files[0]);
        document.getElementById("btn_img_upload").innerHTML = "Change image";
        document.getElementById("prev_post_img").style = "display:block;";
    }
}
$(function () {
    $('#upload').on('change', function () {readURL(input);});
});
let input = document.getElementById( 'upload' );
let infoArea = document.getElementById( 'upload-label' );
input.addEventListener( 'change', showFileName );
function showFileName( event ) {
  let input = event.srcElement;
  let fileName = input.files[0].name;
  infoArea.textContent = 'File name: ' + fileName;
}
</script>


<!-- ni bör lägga denna i footer.php -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>
>>>>>>> Stashed changes
