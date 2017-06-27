<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
       <?php if(isset($_SESSION['isadmin'])){ ?>
      <a class="navbar-brand" href="#">Admin Panel</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="adminpanel.php">Elections</a></li>
        <li><a href="newelection.php">New Election</a></li>
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrator <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="adminsview.php">Manage Administrators</a></li>
            <li><a href="registeradmin.php">New Administrator</a></li>
          </ul>
        </li>
      <li class="nav-item ">
        <li><a href="archive.php">Archive</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="button" class="btn btn-default" value="Logout" onclick=" relocate_home()">

        <script>
        function relocate_home()
        {
             location.href = "logout.php";
        } 
        </script>
        </div>
      </form>
      </ul>
      <?php }elseif (isset($_SESSION['isvoter'])) {?>
        
        <a class="navbar-brand" href="#">Vote KMA</a>
        </div>

        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
           <li><a href="main.php">Elections</span></a></li>
           <li><a href="archive.php">Archive</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
              <form class="navbar-form navbar-left">
              <div class="form-group">
                <input type="button" class="btn btn-default" value="Logout" onclick=" relocate_home()">

                <script>
                  function relocate_home()
                  {
                       location.href = "logout.php";
                  } 
                </script>
              </div>
              </form>
        </ul>
      </div>
  <?php }else{header('Location:index.php');} ?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
  
</nav>