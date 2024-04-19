<style>
  /* CSS for Dropdown */
  .dropdown {
    position: relative;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown-content a:hover {
    background-color: #f1f1f1;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }
</style>

<nav>
  <div class="logo">
    <img src="images/logo.png">
  </div>

  <ul>
    <li class="hideOnMobile"><a href="accueil.php">Accueil</a></li>
    <li class="hideOnMobile"><a href="index.php">Bibliotheque</a></li>
    <li class="hideOnMobile"><a href="voirauteur.php">Auteurs</a></li>
    <li class="hideOnMobile"><a href="#">Reglement</a></li>
    <li class="hideOnMobile"><a href="#contact">Contact</a></li>
    <?php
    session_start(); // Start session to check user login status
    if (isset($_SESSION['user_id'])) {
      // User is logged in
      include('DataBase.php');

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Prepare a statement to fetch user's name based on their ID
      $stmt = $conn->prepare("SELECT Nom FROM user WHERE id = ?");
      $stmt->bind_param("i", $_SESSION['user_id']);
      $stmt->execute();
      $stmt->store_result();

      // Bind the result variables
      $stmt->bind_result($Nom);

      // Fetch the result
      $stmt->fetch();

      // // Close statement
      // $stmt->close();

      // // Close connection
      // $conn->close();

      // Display user's name as a dropdown menu
      echo '<li class="hideOnMobile dropdown">
          <a href="#" class="dropbtn"> <img src="../images/icons/Style=Solid.png" alt="User icon" width="15px">' . $Nom . '</a>
          <div class="dropdown-content">
            <a href="../User_Compte/UserCompte.php"> <img src="../images/icons/Style=Solid (1).png" alt="Home icon icon" width="10px"> Compte</a>
            <a href="../Login/User/logout.php">Déconnexion</a>
          </div>
        </li>';
    } else {
      // User is not logged in
      echo '<li class="hideOnMobile"><a href="../Login/User/Registration.php">Inscription</a></li>';
      echo '<li class="hideOnMobile"><a href="../Login/User/userLogin.php">Login</a></li>';
    }
    ?>
    <div class="menu-button" onclick="showSidebar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 96 960 960" width="26">
          <path d="M120 816v-60h720v60H120Zm0-210v-60h720v60H120Zm0-210v-60h720v60H120Z" />
        </svg></a></div>
    <ul class="sidebar">
      <div onclick="hideSidebar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 96 960 960" width="26">
            <path d="m249 849-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z" />
          </svg></a></div>
      <li><a href="accueil.php">Accueil</a></li>
      <li><a href="index.php">Bibliotheque</a></li>
      <li><a href="#">Reglement</a></li>
      <li><a href="#contact">Contact</a></li>

    </ul>
  </ul>
  <!--search-->

  <form action="" method="GET">
    <div class="search">
      <div class="search-box">
        <div class="search-field">
          <input placeholder="Search..." class="input" type="text" name="search">
          <div class="search-box-icon">
            <button class="btn-icon-content" type="submit">
              <i class="search-icon">
                <svg xmlns="://www.w3.org/2000/svg" version="1.1" viewBox="0 0 512 512">
                  <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" fill="#fff"></path>
                </svg>
              </i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>


  <script>
    function showSidebar() {
      const sidebar = document.querySelector('.sidebar')
      sidebar.style.display = 'flex'
    }

    function hideSidebar() {
      const sidebar = document.querySelector('.sidebar')
      sidebar.style.display = 'none'
    }
  </script>
</nav>