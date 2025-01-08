
<?php
 session_start();
 include '.././src/datacnx.php';
  if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1 ) {
      header("Location: blog.php"); 
      exit();
    }
//for display data
//Requets
$sqldata= $cnx->query('SELECT * FROM user');
//Get values
$users = $sqldata->fetch_all(MYSQLI_ASSOC);

//delet user;
if(isset($_GET['idUser'])){
   $iduse = $_GET['idUser'];
$delet = $cnx->prepare('DELETE FROM user WHERE useId=?');
$delet->execute([$iduse]); 
header('Location: user.php');
}
//chage user role;
if(isset($_GET['idrole'])){
    $iduse = $_GET['idrole'];
 $change = $cnx->prepare('update user set role_id=1 WHERE useId=?');
 $change->execute([$iduse]); 
 header('Location: user.php');
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
                <div class="profile-img bg-img" style="background-image: url(.././img/1054-1728555216.jpg)"></div>
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
                       <a href="user.php" class="active">
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
                        <div class="browse">
                           <input type="search" placeholder="Search" class="record-search">
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
                                    <th><span class="las la-sort"></span>email </th>
                                    <th><span class="las la-sort"></span> username</th>
                                    <th><span class="las la-sort"></span> ROLE</th>
                                    <th><span class="las la-sort"></span> DATE CREAT</th>
                                    <th><span class="las la-sort"></span> ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user){?>
                                <tr>
                                    <td>#<?php echo $user['useId'];?></td>
                                    <td>                                             
                                                <?php echo $user['email'];?>
                                            
                                    </td>
                                    <td>
                                    <?php echo $user['username'];?>
                                    </td>
                                    <td>
                            
                                    <?php if($user['role_id'] == 1){?>
                                        admin <?php }else{?>
                                            client <?php } ?>
                        
                                    </td>
                                     
                                    <td>
                                <?php echo $user['created_at'];?>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <span ><a href="user.php?idUser=<?php echo $user['useId']; ?>"><i class="fa-solid fa-trash"></i></a></span>
                                            <span class="ml-8"><a href="user.php?idrole=<?php echo $user['useId']; ?>"><i class="fa-solid fa-user-tie"></i></a></span>
                   
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