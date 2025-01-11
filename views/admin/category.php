<?php
 require_once '../.././database/connexion.php';
 require_once '../.././class/Category.php';
 $db = new DatabaseConnection();
 $category = new Category($db->getConnection());
 session_start();
 if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1 ) {
     header("Location: blog.php"); 
     exit();
   }
//affiche data in edit 
if(isset($_GET['idEdit'])){
    $id = $_GET['idEdit'];
    $category ->setId( $id);
    $tab = $category ->getCategoryId();
    var_dump($tab);
}

//edit category



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
                       <a href="./article.php">
                       <span><i class="fa-regular fa-newspaper"></i>   </span>                       
                         <small>Articles</small>
                        </a>
                    </li>
                    <li>
                       <a href="./category.php" class="active">
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
                        <form method="post" action="../.././controller/controlCategory.php">
                        <div class="add">
                          <button type="submit" name="addcat"> Add </button>
                          <input class="ml-5" name="namecat" type="text" placeholder="enter Category">
                       </div>
                        </form>
                   
                    <div>
                        
                    </div>
                    <div id="editcat" class="record-header w-[1px] h-[10px] mr-[50px]" >
                        <form method="post" action="../.././controller/controlCategory.php?idcatgr=<?php echo $tab[0]['catId']; ?>">
                             <div class="add">
                          <input class="ml-5" name="nameedit" type="text" placeholder="enter Category" value="<?php echo isset($tab[0]['name']) ?  $tab[0]['name'] : '' ;?>">
                          <button type="submit" name="editcat" id="hideedit">  Edit </button>
                       </div>
                     </form>
                     </div>
                        <div class="browse">
                            
                           <!-- <input type="search" placeholder="Search" class="record-search"> -->
                            <select name="" id="">
                                <option value="">Filtter</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th class="las la-sort">ID</th>
                                    <th><span class="las la-sort"></span>Name Category </th>
                                    <th><span class="las la-sort"></span> ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                           foreach($category->getAllCategory() as $row){
                            ?>
                                <tr>
                                    <td>#<?php echo $row['catId']; ?></td>
                                    <td >

                                                <small class="text-[16px] ml-7"><?php echo $row['name']; ?></small>
                                            
                                        </div>
                                    </td>
                                    
                                    <td class="flex">
                                        <div class="actions ml-3">
                                            <span ><a href="../.././controller/controlCategory.php?iddelcatgr=<?php echo $row['catId']; ?>"><i class="fa-solid fa-trash"></i></a></span>

                                            <span id="editbtn" class="ml-7"><a href="./category.php?idEdit=<?php echo $row['catId']; ?>"><i class="fa-regular fa-pen-to-square"></i></a></span>                        
                                        </div>
                  
                    <div>
                                    </td>
                                </tr>
                               
                                <?php
                           }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            
            </div>
            
        </main>
        
    </div>
   
</body>
</html>