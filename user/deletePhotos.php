<?php 
require("../config/database.php");
session_start();

if(empty($_SESSION['loggedin']))
    header('Location: ../index.php');

if(isset($_POST['delete'])){
    $checkbox = $_POST['check'];
    if(!empty($checkbox)){
        $del_id = implode(",", $checkbox);
        $query = $pdo->prepare("SELECT * FROM picture WHERE id_img IN ($del_id)");
        $query->execute();
        $rowCount = $query->rowCount();
        for($i=0;$i<$rowCount;$i++){
            while($row = $query->fetchAll()){
                foreach($row as $fileToDelete){
                    unlink("../".$fileToDelete['img']);    
                }
            }
        }
        $query = $pdo->prepare("DELETE FROM picture WHERE id_img IN ($del_id)");
        $query->execute();
        $message = "Yaaaaass photos deleted successfully !";
        header("Refresh: 2; url=deletePhotos.php");
    }else{
        $message_err = "Please choose photos to delete";
    }
}
?>

<?php ob_start(); ?>
<div class="background galleryB">
    <div id="test">
    <h2 id="title" style="padding-top:0;text-shadow: 4px 2px 1px #67e8a6;">What's up bitch ? </h2>
        <div id="account">
            <nav id="account_nav">
                <a id="EdPro" href="account.php">Edit Profile</a>
                <a id="EdPwd" href="modifyPassw.php">Edit Password</a>
                <a id="DelPho" href="deletePhotos.php" >Delete Photos</a>
                <a id="DelAcc" href="deleteAccount.php" >Delete Account</a>
                <a id="Notif" href="notifications.php" >Notifications</a>
            </nav>
            <article>
                <div style="max-height: 705px;" id="a">
                    <div class="loginForm accountForm" style="min-height:364px; margin-top: 13px;width: 91%;">      
                        <h2 id="subTitle">Delete Photos</h2>
                            <div id="deletePhotos">
                                <span style="color:green"><?php echo $message; ?></span>
                                <span style="color:red"><?php echo $message_err; ?></span>
                                <form method="POST" action="">
                                    <?php 
                                        $stmt = $pdo->prepare("SELECT img, id_img FROM picture WHERE id_user = :id_user ORDER BY date DESC");
                                        $stmt->bindParam(":id_user", $_SESSION['id']);
                                        $stmt->execute();
                                        while ($res = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                                            foreach($res as $photos){
                                                echo "
                                                <div id='img'>
                                                    <img src='../".$photos['img']."'>
                                                    <input type='checkbox' id='check_del' name='check[]' value='".$photos['id_img']."'>
                                                </div>";
                                            }
                                        }
                                    ?>
                                     </div>
                                     <div class="loginForm accountForm" style="background:none; box-shadow:none">
                        
                                             <input type="submit" id="saveBtt" style="width: 22%;margin-top: 11px;font-size: 24px;margin-bottom:7px" name="delete" value="Delete">          
                                </form>
                            </div>
                    </div><br>
                </div>
            </article>
        
        </div>
    </div>
</div>

<?php $view = ob_get_clean(); ?>
<?php require("../template.php"); ?>