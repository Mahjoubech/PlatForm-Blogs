 <!-- <?php
//  session_start();
// include ("./src/datacnx.php");
// if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1 ) {
//     header("Location: blog.php"); 
//     exit();
//   }
//   $stmt = $cnx->query("SELECT COUNT(*) AS total_user FROM user");
//   $client = $stmt->fetch_assoc();
//   $stmt = $cnx->query("SELECT COUNT(*) AS total_art FROM article");
//   $articls = $stmt->fetch_assoc();
//   $stmt = $cnx->query("SELECT COUNT(*) AS total_cmnt FROM comments");
//   $cmntes = $stmt->fetch_assoc();
//   $stmt = $cnx->query("SELECT COUNT(*) AS total_like FROM likes");
//   $likess = $stmt->fetch_assoc();



?>  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    

</head>
<body>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
        <div class="flex items-center"style="display:flex; align-item:center;">
                    <i class="fas fa-blog mr-2" style="margin-right:5px;"></i>
                    <h1 class=" font-bold" style="font-size:20px;">BlogPlatform</h1>
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
                       <a href="dachboard.php" class="active">
                       <span><i class="fa-solid fa-igloo"></i></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="./admin/user.php">
                       <span><i class="fa-regular fa-user"></i></span>
                            <small>users</small>
                        </a>
                    </li>
                    <li>
                       <a href="./admin/article.php">
                       <span><i class="fa-regular fa-newspaper"></i>   </span>                       
                         <small>Articles</small>
                        </a>
                    </li>
                    <li>
                       <a href="./admin/category.php">
                     <span> <i class="fa-solid fa-tag"></i> </span>                        
                           <small>Category</small>
                        </a>
                    </li>
                    <li>
                       <a href="./admin/comments.php">
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
                        <a href="logout.php"> <span class="las la-power-off"></span>
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
            
                <div class="analytics">

                    <div class="card">
                        <div class="card-head">
                            <h2><?php echo $client['total_user']?> </h2>
                            <span class="las la-user-friends"></span>
                        </div>
                        <div class="card-progress">
                            <small>User creat acount</small>
                            <div class="card-indicator">
                                <div class="indicator one" style="width: <?php echo $client['total_user'] ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head">
                            <h2><?php echo $likess['total_like'] ?></h2>
                            <span ><i class="fa-regular fa-thumbs-up"></i></span>
                        </div>
                        <div class="card-progress">
                            <small>How many likes </small>
                            <div class="card-indicator">
                                <div class="indicator two" style="width: <?php echo $likess['total_like'] ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head">
                            <h2><?php echo $cmntes['total_cmnt'] ?></h2>
                            <span ><i class="fa-regular fa-comment"></i></span>
                        </div>
                        <div class="card-progress">
                            <small>how many comments</small>
                            <div class="card-indicator">
                                <div class="indicator three" style="width: <?php echo $cmntes['total_cmnt'] ?>%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2><?php echo $articls['total_art']?></h2>
                            <span ><i class="fa-solid fa-newspaper"></i></span>
                        </div>
                        <div class="card-progress">
                            <small>How many Article creat</small>
                            <div class="card-indicator">
                                <div class="indicator four" style="width: <?php echo $articls['total_art']?>%"></div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="records table-responsive">

                    <div class="record-header">
                        <div class="add">
                            <span>Entries</span>
                            <select name="" id="">
                                <option value="">ID</option>
                            </select>
                            <button>Add record</button>
                        </div>

                        <div class="browse">
                           <input type="search" placeholder="Search" class="record-search">
                            <select name="" id="">
                                <option value="">Status</option>
                            </select>
                        </div>
                    </div>

                    <div>
                       
                    </div>

                </div>
            
            </div>
            
        </main>
        
    </div>
</body>
</html>