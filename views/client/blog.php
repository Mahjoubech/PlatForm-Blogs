
<?php
 session_start();
include ("./src/datacnx.php");
//for display data category
 //Requets
 $sqldata= $cnx->query('SELECT * from category order by catId Asc');
 //Get values
 $category = $sqldata->fetch_all(MYSQLI_ASSOC);
//get data articles from database to blog page
$sql = $cnx->query('SELECT * ,user.username as name , category.name as catname  FROM article  join user on  article.userId = user.useId join category on article.categId = category.catId  order by art_Id desc ;');
$articles = $sql->fetch_all(MYSQLI_ASSOC);
//add article from user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addArt'])) {
    $user = $_SESSION['user']['useId'];
    $catg = $_POST['slectCat'];
    $title = $_POST['titleblog'];
    $img = $_POST['lienimage'];
    $desc = $_POST['descrp'];

    if (!empty($catg) && !empty($title) && !empty($img) && !empty($desc)) {
        // Insérer dans la base de données
        $query = $cnx->query("INSERT INTO `article` (`userId`, `title`, `content`, `image`, `categId`) 
                              VALUES ('$user', '$title', '$desc', '$img', '$catg')");
        if ($query) {
            header('Location: blog.php');
        } else {
            die("Erreur SQL : " . $cnx->error);
        }
    }
}
//delet category
if(isset($_GET['idArt'])){
    $artid = $_GET['idArt'];
    $delet = $cnx->prepare('DELETE FROM article WHERE art_Id=?');
    $delet->execute([$artid]);
 header('Location: blog.php');
 }

 //get value for edit
   //Get values
   if(isset($_GET['idArtedt'])){
   
       $id = $_GET['idArtedt'];
       $edit = "SELECT * FROM `article` WHERE art_Id = $id";
       $result = mysqli_query($cnx, $edit);
       $cos = mysqli_fetch_assoc($result);
       if(isset($cos)) {
           echo "<script>
               console.log(document.getElementById('articleFormedit'));
               document.addEventListener('DOMContentLoaded', () => {
                   document.getElementById('articleFormedit').classList.toggle('active');
               })
           </script>";
          
       }
   }
  //get data articles from database 
  $sql = $cnx->query('SELECT * ,user.username as name , article.title as arttitle  FROM comments join user on  comments.user_id = user.useId join article on comments.article_id = article.art_Id order by cmmId;');
  $cmnts= $sql->fetch_all(MYSQLI_ASSOC);
  //add cmnt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addcmnt'])) {
    $user = $_SESSION['user']['useId'];
    $artc = $_POST['idArtcmnt'];
    $title = $_POST['comntpost'];

    if (!empty($artc) && !empty($title) ) {
        // Insérer dans la base de données
        $query = $cnx->query("INSERT INTO `comments` (`article_id`, `user_id`, `cmnter`) 
                              VALUES ('$artc', '$user', '$title')");
        if ($query) {
            header('Location: blog.php');
        } else {
            die("Erreur SQL : " . $cnx->error);
        }
    }
}
//number commnetr
// Fetch comment counts
$commentCounts = [];
$result = $cnx->query("SELECT article_id, COUNT(*) AS total_comments FROM comments GROUP BY article_id");
while ($row = $result->fetch_assoc()) {
    $commentCounts[$row['article_id']] = $row['total_comments'];
}
//delet comment
if(isset($_GET['deletcmnt'])){
    $cmmId = $_GET['deletcmnt'];
 $delet = $cnx->prepare('DELETE FROM comments WHERE cmmId=?');
 $delet->execute([$cmmId]); 
 header('Location: blog.php');
 }

 // get like

// $likees = [];
// $result = $cnx->query("SELECT article_id, COUNT(*) AS total_like FROM likes GROUP BY article_id");
// while ($row = $result->fetch_assoc()) {
//     $likees[$row['article_id']] = $row['total_like'];
// }

// Vérifier si un utilisateur est connecté
if (isset($_SESSION['user']['useId'])) {
    $userId = $_SESSION['user']['useId'];

    // Récupérer les articles likés par l'utilisateur
    $userLikes = [];
    $result = $cnx->query("SELECT article_id FROM likes WHERE userId = $userId");
    while ($row = $result->fetch_assoc()) {
        $userLikes[] = $row['article_id'];
    }

    // Ajouter un like
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like'])) {
        $articleId = $_POST['article_id'];
        if (!in_array($articleId, $userLikes)) {
            $query = $cnx->prepare("INSERT INTO likes (article_id, userId) VALUES (?, ?)");
            $query->bind_param("ii", $articleId, $userId);
            $query->execute();
            header('Location: blog.php');
            exit;
        }
    }

    // Supprimer un like
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unlike'])) {
        $articleId = $_POST['article_id'];
        if (in_array($articleId, $userLikes)) {
            $query = $cnx->prepare("DELETE FROM likes WHERE article_id = ? AND userId = ?");
            $query->bind_param("ii", $articleId, $userId);
            $query->execute();
            header('Location: blog.php');
            exit;
        }
    }
}
$result = $cnx->query("SELECT article_id, COUNT(*) AS total_like FROM likes GROUP BY article_id");
while ($row = $result->fetch_assoc()) {
    $likees[$row['article_id']] = $row['total_like'];
}


?>


 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="refresh" content="2"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Blog Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="tailwind.config.js"></script>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
     
    </script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-secondary text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-blog mr-2"></i>
                    <h1 class="text-xl font-bold">BlogPlatform</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                <?php if(!isset($_SESSION['user'])){ ?>
                    <button id="loginBtn" class="text-neutral hover:text-white" hidden>
                       <a href="./logout.php"><i class="fas fa-sign-in-alt mr-1"></i>Logout</a> 
                    </button>
                    <?php }else{ ?>
                        <button id="loginBtn" class="text-neutral hover:text-white">
                       <a href="./logout.php"><i class="fas fa-sign-in-alt mr-1"></i>Logout</a> 
                    </button>
                    <?php } ?>
                    <button id="registerBtn" class="bg-primary text-white px-4 py-2 rounded hover:bg-opacity-90">
                       <a href="./singup.php"><i class="fas fa-user-plus mr-1"></i>Sign Up</a> 
                    </button>
                    <?php if(!isset($_SESSION['user'])){ ?>
                        <div class="adminicons" hidden>
                        <a href="dachboard.php"> <i class="fa-solid fa-user-tie"></i>
                             <h5>Dashboard</h5></a>
                             
                   
                </div>
                <?php }else{ ?>
                    <div class="adminicons">
                        <a href="dachboard.php"> <i class="fa-solid fa-user-tie"></i>
                             <h5>Dashboard</h5></a>
                             
                   
                </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Category Filter -->
        <div class="mb-8">
            <div class="flex space-x-4">
                <button class="bg-primary text-white px-4 py-2 rounded hover:bg-opacity-90 category-filter active">
                   All
                </button>
                <?php foreach($category as $catg){?>

                <button class="bg-neutral text-white px-4 py-2 rounded hover:bg-opacity-90 category-filter">
                    <?php echo $catg['name']?>
                </button>
                <?php } ?>
            </div>
        </div>

        <!-- Add Article Button -->
        <button id="addArticleBtn" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-opacity-90 mb-8">
            <i class="fas fa-plus mr-2"></i>Add Article
        </button>

        <!-- Add Article Form -->
        <div id="articleForm" class="slide-down bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-secondary">
                <i class="fas fa-pen-to-square mr-2"></i>Create New Article
            </h2>
            <form method="post" action="blog.php">
                <div class="mb-4">
                    <label class="block text-secondary mb-2">
                        <i class="fas fa-heading mr-1"></i>Title
                    </label>
                    <input name="titleblogedt" type="text" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary" required>
                </div>
                <div class="mb-4">
                    <label class="block text-secondary mb-2">
                        <i class="fas fa-tag mr-1"></i>Category
                    </label>
                    <select name="slectCatedt" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary" required>
                    <option value="" disabled selected>Select category </option>
                    <?php foreach($category as $catg){?>
                    <option value="<?php echo $catg['catId']?>"><?php echo $catg['name']?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-secondary mb-2">
                        <i class="fas fa-paragraph mr-1"></i>Content
                    </label>
                    <textarea name="descrpedt" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary" rows="6" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-secondary mb-2">
                        <i class="fas fa-image mr-1"></i>Image
                    </label>
                    <input name="lienimageedt" type="text" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary" required>
                </div>
                <button name="addArtedt" type="submit" class="bg-primary text-white px-6 py-2 rounded hover:bg-opacity-90">
                    <i class="fas fa-paper-plane mr-1"></i>Publish
                </button>
            </form>
        </div>

        <!-------------- Edit article format ------------------>
        <div id="articleFormedit" class="slide-down bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-secondary">
                <i class="fas fa-pen-to-square mr-2"></i>Update Article
            </h2>
            <form method="post" action="./admin/editblog.php?ideditart=<?php echo $cos['art_Id']?>">
                <div class="mb-4">
                    <label class="block text-secondary mb-2">
                        <i class="fas fa-heading mr-1"></i>New Title
                    </label>
                    <input name="titleblog" type="text" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary"  value="<?php if(isset($cos['title'])) echo $cos['title']?>" >
                </div>
                <div class="mb-4">
                    <label class="block text-secondary mb-2">
                        <i class="fas fa-tag mr-1"></i>New Category
                    </label>
                    <select name="selectCat" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary">
                    <option value="" disabled selected>Select category </option>
                    <?php foreach($category as $catg){?>
                    <option value="<?php echo $catg['catId']?>"><?php echo $catg['name']?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-secondary mb-2">
                        <i class="fas fa-paragraph mr-1"></i>New Content
                    </label>
                    <textarea name="descrp" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary" rows="6"><?php if(isset($cos['content'])) echo $cos['content']?></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-secondary mb-2">
                        <i class="fas fa-image mr-1"></i>New Image
                    </label>
                    <input name="lienimage" type="text" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary" value=" <?php if(isset($cos['image'])) echo $cos['image']?>">
                </div>
                <button name="EDITart" type="submit" class="bg-primary text-white px-6 py-2 rounded hover:bg-opacity-90">
                    <i class="fas fa-paper-plane mr-1"></i>Edit
                </button>
            </form>
        </div>
        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3  gap-8">
            <!-- Sample Article Card -->
             <?php foreach($articles as $art){ ?>
            <article class="bg-white rounded-lg shadow-md overflow-hidden fade-in active h-auto ">
                <img src="<?php echo $art['image']?>" alt="Article image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-primary text-sm font-semibold">
                            <i class="fas fa-tag mr-1"></i><?php echo $art['catname']?>
                        </span>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['useId'] === $art['userId']) { ?>
                        <div class="flex space-x-2">
                        <a href="blog.php?idArtedt=<?php echo $art['art_Id']?>"> <button id="editId" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-edit"></i></button></a>
                            </button>
                            <a href="blog.php?idArt=<?php echo $art['art_Id']?>"><button class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button></a>
                        </div>
                        <?php }?>
                    </div>

                    <div class="flex items-center mb-3 text-neutral text-sm">
                        <i class="fas fa-clock mr-2"></i>
                        <span><?php echo $art['created_at']?></span>
                        <i class="fas fa-user mx-2"></i>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['useId'] === $art['userId']) { ?>
                         <span>You</span>
                         <?php }else{?>
                        <span><?php echo $art['name']?></span>
                        <?php }?>
                    </div>

                    <h3 class="text-secondary text-xl font-bold mt-2"><?php echo $art['title']?></h3>
                    <p class="text-neutral mt-2"><?php echo $art['content']?></p>
                    
                    <!-- Comments Section -->
                    <div class="mt-4 border-t pt-4">
                        <div class="comments-container">
                            <!-- Existing Comments -->
                            <div class="existing-comments space-y-4">

                                <!-- Sample Comment -->
                                 <?php foreach($cmnts as $cmt){?>
                                 
                                    <?php if($cmt['article_id'] === $art['art_Id'] ){?>
                                <div class="bg-gray-50 p-3 rounded new-comment ">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-sm">JD</div>
                                        <div class="ml-3">
                                            <p class="text-secondary font-semibold"><?php echo $cmt['name']?></p>
                                            <p class="text-neutral text-sm">
                                                <i class="fas fa-clock mr-1"></i><?php echo $cmt['created_at']?>
                                            </p>
                                        </div>
                                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['useId'] === $cmt['user_id']) { ?>
                       
                                      <a href="blog.php?deletcmnt=<?php echo $cmt['cmmId']?>"><button class="text-red-500 hover:text-red-700 ml-[100px]">
                                        <i class="fas fa-trash"></i>
                                         </button></a>
                      
                        <?php }?>
                                    </div>
                                  <p class="text-secondary"><?php echo $cmt['cmnter']?></p>
                                </div>
                                 <?php }?>
                                 <?php }?>

                                   
                            </div>
                            
                            <!-- Comment Form -->
                            <div class="comment-form comment-slide mt-4">
                                <form method="post" action="blog.php" class="space-y-4">
                                <input type="hidden" name="idArtcmnt" value="<?php echo $art['art_Id']; ?>">
                                    <textarea placeholder="Write your comment..." class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary" rows="3" name="comntpost"></textarea>                                    <button type="submit" name="addcmnt" class="bg-primary text-white px-4 py-2 rounded hover:bg-opacity-90">
                                            
                                    <i class="fas fa-paper-plane mr-1"></i>
                                        Post Comment 
                                    </button>
                                  
                                    
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center space-x-4">

                        <form method="POST" action="blog.php" style="display: flex;">
    <input type="hidden" name="article_id" value="<?php echo $art['art_Id']; ?>">
    <?php if (isset($userLikes) && in_array($art['art_Id'], $userLikes)): ?>
        <!-- Unlike -->
        <button type="submit" name="unlike" class="text-primary hover:text-primary bg-transparent">
            <i class="fas fa-heart"></i>
            <span class="ml-1"><?php echo isset($likees[$art['art_Id']]) ? $likees[$art['art_Id']] : 0; ?></span>
        </button>
    <?php else: ?>
        <!-- Like -->
        <button type="submit" name="like" class="text-neutral hover:text-primary bg-transparent">
            <i class="far fa-heart"></i>
            <span class="ml-1"><?php echo isset($likees[$art['art_Id']]) ? $likees[$art['art_Id']] : 0; ?></span>
        </button>
              <?php endif; ?>
             </form>


                            <button class="text-neutral hover:text-primary comment-toggle">
                                <i class="far fa-comment"></i>
                                <span class="ml-1"> <?php echo isset($commentCounts[$art['art_Id']]) ? $commentCounts[$art['art_Id']] : 0; ?></span>
                            </button>
                        </div>
                        <span class="text-neutral text-sm">
                            <i class="fas fa-clock mr-1"></i>2 hours ago
                        </span>
                    </div>
                </div>
            </article>

             <?php }?>
           
        </div>
    </div>

    <script>
        // Toggle Article Form
        const addArticleBtn = document.getElementById('addArticleBtn');
        const articleForm = document.getElementById('articleForm');

        addArticleBtn.addEventListener('click', () => {
            articleForm.classList.toggle('active');
        });
        

        // Category Filter
        const categoryButtons = document.querySelectorAll('.category-filter');
        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                categoryButtons.forEach(btn => btn.classList.remove('bg-primary'));
                categoryButtons.forEach(btn => btn.classList.add('bg-neutral'));
                button.classList.remove('bg-neutral');
                button.classList.add('bg-primary');
            });
        });

        // Comment Toggle
        document.querySelectorAll('.comment-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const article = button.closest('article');
                const commentForm = article.querySelector('.comment-form');
                commentForm.classList.toggle('active');
            });
        });

        
        

        
  
    </script>
</body>
</html>