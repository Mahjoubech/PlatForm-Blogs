
<?php 
session_start();
require_once  "../../database/connexion.php";
require_once   "../../class/Article.php";

// if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1 ) {
//    header("Location: blog.php"); 
//    exit();
//  }

$db = new DatabaseConnection();
$articles = new Article($db->getConnection());
// var_dump($articles->getAllArticles());

//Requets

// $sqldata= $cnx->query('SELECT * from category ');
// //Get values
// $category = $sqldata->fetch_all(MYSQLI_ASSOC);

// //get data articles from database 
// $sql = $cnx->query('SELECT * ,user.username as name , category.name as catname  FROM article join user on  article.userId = user.useId join category on article.categId = category.catId;');
// $articles = $sql->fetch_all(MYSQLI_ASSOC);

// //add article 
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addArt'])) {
//     $user = $_SESSION['user']['useId'];
//     $catg = $_POST['selectCat'];
//     $title = $_POST['titleblog'];
//     $img = $_POST['lienimage'];
//     $desc = $_POST['descrp'];

//     if (!empty($catg) && !empty($title) && !empty($img) && !empty($desc)) {
//         // Insérer dans la base de données
//         $query = $cnx->query("INSERT INTO `article` (`userId`, `title`, `content`, `image`, `categId`) 
//                               VALUES ('$user', '$title', '$desc', '$img', '$catg')");
//         if ($query) {
//             header('Location: article.php');
//         } else {
//             die("Erreur SQL : " . $cnx->error);
//         }
//     }
// }


//delet article
// if(isset($_GET['articleId'])){
//     $artid = $_GET['articleId'];
//  $delet = $cnx->prepare('DELETE FROM article WHERE art_Id=?');
//  $delet->execute([$artid]); 
//  header('Location: article.php');
//  }


//  //get value for edit
   //Get values
   if(isset($_GET['articleIdedit'])){
   
       $id = $_GET['articleIdedit'];
       $edit = "SELECT * FROM `article` WHERE art_Id = ?";
       $result = $db->getConnection()-> prepare( $edit);
       $result->execute([$id]);
       $row = $result->fetch(PDO::FETCH_ASSOC);
       var_dump($row);
       if(isset($row)) {
           echo "<script>
               console.log(document.getElementById('editcontform'));
               document.addEventListener('DOMContentLoaded', () => {
                   document.getElementById('editcontform').classList.add('actve');
               })
           </script>";
       }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="../.././assets/css/style.css">
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
                       <a href="./article.php" class="active">
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
                       <a href="./comments.php">
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
                        
                        <a href="../logout.php"><span class="las la-power-off"></span>
                        <span>Logout</span></a>
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
                    <div  class="add" >
                          <button id="addarticle" class="add_article">+ Add Article</button>
                    </div>
                        <div class="browse">
                           <input type="search" placeholder="Search" class="record-search">
                            <select name="" id="">
                                <option value="">Filtter</option>
                            </select>
                        </div>
                    </div>
     
    <input type="file" id="fileInput" accept="image/*">       
                    <div>
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th class="las la-sort">ID</th>
                                    <th><span class="las la-sort"></span>TITLE </th>
                                    <th><span class="las la-sort"></span> DESCRIPTION</th>
                                    <th><span class="las la-sort"></span>CATEGORY</th>
                                    <th><span class="las la-sort"></span> POSTED BY</th>
                                    <th><span class="las la-sort"></span> IMAGE</th>
                                    <th><span class="las la-sort"></span> CREATIO DATE</th>
                                    <th><span class="las la-sort"></span> ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($articles->getAllArticles()as $art) {?>
                                <tr>
                                    <td>#<?php echo $art['art_Id'] ?></td>
                                    <td>
                            
                                                <small><?php echo $art['title'] ?></small>
                                            
                                        </div>
                                    </td>
                                    <td>
                            
                                    <?php echo $art['content'] ?>
                        
                                    </td>
                                    <td>
                                         <?php echo $art['catname']?>
                                    </td>
                                    <td>
                                         <?php echo $art['name']?>
                                    </td>
                                    <td>
                                       <div class="image_art">
                                        <img src="<?php echo $art['image'] ?>" alt="">
                                       </div>
                                    </td>
                                    <td>
                                    <?php echo $art['created_at'] ?>
                                    </td>
                                    <td>
                                        <div class="actions ml-3">
                                            <a href="article.php?articleId=<?php echo $art['art_Id']?>"><span ><i class="fa-solid fa-trash"></i></span></a>
                                            <a href="article.php?articleIdedit=<?php echo $art['art_Id']?>"><span  class="ml-7 editbtn"><i class="fa-regular fa-pen-to-square"></i></span></a>
                        
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
     <!------- form add article ------------->
     <div id="formarticle" class="containers fixed top-40 right-[-100%]  shadow-[2px_0_10px_rgba(0,0,0,0.1)] p-6 flex flex-col gap-5 transition-all duration-700 ease-in-out z-50 ">
      <div class="wrapper">
        <div class="post">
          <header>Create Article</header>
          <form method="post" action="article.php">
            <div class="content">
              <img src=".././img/1054-1728555216.jpg" alt="logo">
              <div class="details">
                <p><?php echo $_SESSION['user']['username']?></p>
                 
                  <select name="selectCat" class="text-[11px] bg-gray-200 text-black p-2 rounded-md focus:outline-none" >
                    <option value="" disabled selected>Select category </option>
                    <?php foreach($category as $catg){?>
                    <option value="<?php echo $catg['catId']?>"><?php echo $catg['name']?></option>
                    <?php } ?>
                  </select>
              </div>
            </div>
            <input type="text" name="titleblog" class="titleblog"spellcheck="false" placeholder="Title">
            <textarea name="descrp" placeholder="What's on your mind, Cherkaoui?" spellcheck="false" required></textarea>
           
            <div class="options">
              <input type="text" name="lienimage" id="imag" placeholder="Add Lien Src Image">
              <ul class="list">
                <li id="uploadBtn"><img src=".././img/gallery.svg" alt="gallery"></li>
              </ul>
            </div>
            <button type="submit" name="addArt">Add</button>
            
          </form>
      </div>
    </div>
     </div>


     <!---- form edit article----->
     <div id="editcontform" class="containers fixed top-40 right-[-100%]  shadow-[2px_0_10px_rgba(0,0,0,0.1)] p-6 flex flex-col gap-5 transition-all duration-700 ease-in-out z-50 ">
      <div class="wrapper">
        <div class="post">
          <header>Update Article</header>
          <form method="post" action="editarticle.php?ideditart=<?php echo $row['art_Id']?>">
            <div class="content">
              <img src=".././img/1054-1728555216.jpg" alt="logo">
              <div class="details">
                <p><?php echo $_SESSION['user']['username']?></p>
                 
                  <select name="editselectCat" class="text-[11px] bg-gray-200 text-black p-2 rounded-md focus:outline-none" >
                    <option value="" disabled selected>Select category </option>
                    <?php foreach($category as $catg){?>
                    <option value="<?php echo $catg['catId']?>"><?php echo $catg['name']?></option>
                    <?php } ?>
                  </select>
              </div>
            </div>
            <input type="text" name="edittitleblog" class="titleblog"spellcheck="false" placeholder="Title" value="<?php if(isset($row['title'])) echo $row['title']?>">
            <textarea name="editdescrp" placeholder="What's on your mind, Cherkaoui?" value="" spellcheck="false" required ><?php if(isset($row['content'])) echo $row['content']?></textarea>
           
            <div class="options">
              <input type="text" name="editlienimage" id="imag" placeholder="Add Lien Src Image" value="<?php if(isset($row['image'])) echo $row['image']?>">
              <ul class="list">
                <li id="uploadBtn"><img src=".././img/gallery.svg" alt="gallery"></li>
              </ul>
            </div>
            <button type="submit" name="edtArt">EDIT</button>
            
          </form>
      </div>
    </div>
     </div>



    

    
    <script >
    

const uploadBtn = document.getElementById('uploadBtn');
const fileInput = document.getElementById('fileInput');
const imagePreview = document.getElementById('imagePreview');
const postText = document.getElementById('postText');

// Trigger file input when button is clicked
uploadBtn.addEventListener('click', () => {
    fileInput.click();
});

document.getElementById('addarticle').addEventListener('click', function(e) {
    e.preventDefault()
    document.getElementById('formarticle').classList.add('actve');
});
// document.querySelectorAll('.editbtn').addEventListener('click', function(e) {
//     e.preventDefault()
//     document.getElementById('editformarticle').classList.add('actve');
// });
    </script>
</body>
</html>