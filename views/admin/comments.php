<?php 
 session_start();
 include (".././src/datacnx.php");
 if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1 ) {
     header("Location: blog.php"); 
     exit();
   }
    //Requets
$sqldata= $cnx->query('SELECT art_Id,title from article ');
//Get values
$artcles = $sqldata->fetch_all(MYSQLI_ASSOC);
   //get data from data base
   //get data articles from database 
   $sql = $cnx->query('SELECT * ,user.username as name , article.title as arttitle  FROM comments join user on  comments.user_id = user.useId join article on comments.article_id = article.art_Id order by cmmId;');
   $cmnts= $sql->fetch_all(MYSQLI_ASSOC);
//add cmnt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addcmnt'])) {
    $user = $_SESSION['user']['useId'];
    $artc = $_POST['slctart'];
    $title = $_POST['contcmnt'];

    if (!empty($artc) && !empty($title) ) {
        // Insérer dans la base de données
        $query = $cnx->query("INSERT INTO `comments` (`article_id`, `user_id`, `cmnter`) 
                              VALUES ('$artc', '$user', '$title')");
        if ($query) {
            header('Location: comments.php');
        } else {
            die("Erreur SQL : " . $cnx->error);
        }
    }
}
//delet comment
if(isset($_GET['commId'])){
    $cmmId = $_GET['commId'];
 $delet = $cnx->prepare('DELETE FROM comments WHERE cmmId=?');
 $delet->execute([$cmmId]); 
 header('Location: comments.php');
 }
 //get data from table to edit 
  if(isset($_GET['commIdedit'])){

    $id = $_GET['commIdedit'];
    $edit = "SELECT * FROM `comments` WHERE cmmId = $id";
    $result = mysqli_query($cnx, $edit);
    $tab = mysqli_fetch_assoc($result);

   
}
   ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href=".././css/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
        <div class="flex items-center">
                    <i class="fas fa-blog mr-2"></i>
                    <h1 class="text-xl font-bold">BlogPlatform</h1>
                </div>
        </div>
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(img/3.jpeg)"></div>
                <h4><?php echo $_SESSION['user']['username']?></h4>
                <small>Admin</small>
            </div>
            <div class="side-menu">
                <ul>
                    <li>
                       <a href="../dachboard.php" >
                       <span><i class="fa-solid fa-igloo"></i></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="./user.php" >
                       <span><i class="fa-regular fa-user"></i></span>
                            <small>users</small>
                        </a>
                    </li>
                    <li>
                       <a href="./article.php">
                       <span><i class="fa-regular fa-newspaper"></i>   </span>                       
                         <small>Articles</small>
                        </a>
                    </li>
                    <li>
                       <a href="./category.php">
                     <span> <i class="fa-solid fa-tag"></i> </span>                        
                           <small>Category</small>
                        </a>
                    </li>
                    <li>
                       <a href="./comments.php" class="active">
                      <span><i class="fa-regular fa-comment"></i></span> 
                            <small>Comments</small>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    <label for="">
                        <span class="las la-search"></span>
                    </label>
                    
                   
                    
                    <div class="notify-icon">
                        <span class="las la-bell"></span>
                        <span class="notify">3</span>
                    </div>
                    
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        
                        <a href="../logout.php"></a><span class="las la-power-off"></span>
                        <span>Logout</span>
                    </div>
                </div>
            </div>
        </header>
        
        
        <main>
            
            <div class="page-header">
                <h1>Dashboard</h1>
                <small>Home / Dashboard</small>
            </div>
            
            <div class="page-content">

                <div class="records table-responsive">
             
                    <div class="record-header">
                    <form method="post" action="comments.php" class="flex ">
                        <div class="add">
                          <button type="submit" name="addcmnt"> Add </button>
                          <input class="ml-5" name="contcmnt" type="text" placeholder="enter comment" required>
                       </div>
                       <div class="browse">
                       <select name="slctart" id="">
                                <option value="" disabled selected required>Article</option>
                                <?php foreach($artcles as $artc){?>
                                <option value="<?php echo $artc['art_Id'] ?>"><?php echo $artc['title'] ?></option>

                                <?php }?>    
                            </select>
                       </div>
                        </form>
                   
                        <div class="browse">
                      
                        <form method="post" action="editcmment.php?cmmEdit=<?php echo $tab['cmmId']?>" class="flex ">
                        <div class="add">
                        <select name="slctart" id="">
                                <option value="" disabled selected>Article</option>
                                <?php foreach($artcles as $artc){?>
                                <option value="<?php echo $artc['art_Id'] ?>"><?php echo $artc['title'] ?></option>

                                <?php }?>    
                        </select>
                          <input class="ml-5" name="namecmnt" type="text" placeholder="enter comment" value="<?php echo isset($tab['cmnter'])?  $tab['cmnter'] : ''?>">
                          <button type="submit" name="addcmnt"> EDIT </button>

                                </div>
                       
                        </form>
                           
                           
                        </div>
                    </div>

                    <div>
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th class="las la-sort">ID</th>
                                    <th><span class="las la-sort"></span>ARTICLE TITLE</th>
                                    <th><span class="las la-sort"></span> USENAME</th>
                                    <th><span class="las la-sort"></span>CONTENT</th>
                                    <th><span class="las la-sort"></span> DATE CREAT</th>
                                    <th><span class="las la-sort"></span> ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cmnts as $cmt){ ?>
                                <tr>
                                    <td>#<?php echo $cmt['cmmId']; ?></td>
                                    <td>
                      
                                 
                                              
                                                <small><?php echo $cmt['arttitle'] ;?></small>
                                            
                                        </div>
                                    </td>
                                    <td>
                                          <?php echo $cmt['name'];?>
                        
                                    </td>
                                    <td>
                                    <?php echo $cmt['cmnter'];?>
                                    </td>
                                    <td>
                                    <?php echo $cmt['created_at'];?>
                                    </td>
                                    <td>
                                        <div class="actions ml-3">
                                        <a href="comments.php?commId=<?php echo $cmt['cmmId']?>"><span ><i class="fa-solid fa-trash"></i></span></a>
                                        <a href="comments.php?commIdedit=<?php echo $cmt['cmmId']?>"><span  class="ml-7 editbtn"><i class="fa-regular fa-pen-to-square"></i></span></a>
                        
                                        </div>
                                    </td>
                                </tr>
                               
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            
            </div>
            
        </main>
        
    </div>
</body>
</html>