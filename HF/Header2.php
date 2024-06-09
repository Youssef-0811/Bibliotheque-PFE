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

  /* CSS for Notifications */
  .notification-count {
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    vertical-align: super;
    position: absolute;
    margin-left: -10px;
    margin-top: -10px;
  }

  .notification-table-wrapper {
    max-height: 200px;
    overflow-y: auto;
  }

  .notification-table {
    width: 100%;
    border-collapse: collapse;
  }

  .notification-table th,
  .notification-table td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
  }

  .notification-table th {
    background-color: #f2f2f2;
  }

  .notification-message {
    width: 100%;
  }

  .notification-dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 240px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .notification-dropdown:hover .notification-dropdown-content {
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
    <li class="hideOnMobile"><a href="#">Reglement</a></li>
    <li class="hideOnMobile"><a href="#contact">Contact</a></li>
    <?php
    // Check if the session is not already started
    if (!isset($_SESSION)) {
      session_start();
    }

    // Include database connection
    include('DataBase.php');

    if (isset($_SESSION['user_id'])) {
      // Get the user's name and notification count
      $stmt_user = $conn->prepare("SELECT Nom FROM user WHERE id = ?");
      $stmt_user->bind_param("i", $_SESSION['user_id']);
      $stmt_user->execute();
      $stmt_user->bind_result($Nom);
      $stmt_user->fetch();
      $stmt_user->close();

      $stmt_notifications = $conn->prepare("SELECT COUNT(*) as unread_count FROM notifications WHERE user_id = ? AND Status = 0");
      $stmt_notifications->bind_param("i", $_SESSION['user_id']);
      $stmt_notifications->execute();
      $stmt_notifications->bind_result($unread_count);
      $stmt_notifications->fetch();
      $stmt_notifications->close();
      echo '<li class="hideOnMobile dropdown">
            <a href="#" class="dropbtn">
                <img src="../images/Bell_Icon.svg" alt="Notifications" width="24px">
                <span class="notification-count" id="notification-count">' . $unread_count . '</span>
            </a>
            <div class="dropdown-content" id="notifications-dropdown">
                <div id="notifications-container">Loading notifications...</div>
            </div>
        </li>';

      echo '<li class="hideOnMobile dropdown">
            <a href="#" class="dropbtn"> ' . htmlspecialchars($Nom) . '</a>
            <div class="dropdown-content">
              <a href="../User_Compte/Edit_Infos/editInfos.php"><img src="../images/icons/Style=Solid (1).png" alt="Home icon" width="10px"> Compte</a>
              <a href="../Login/User/logout.php">Déconnexion</a>
            </div>
          </li>';
    } else {
      echo '<li class="hideOnMobile"><a href="../Login/User/userLogin.php">Login</a></li>';
    }
    ?>
  </ul>
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

  <script>
    function showSidebar() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.style.display = 'flex';
    }

    function hideSidebar() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.style.display = 'none';
    }

    function fetchNotifications() {
      const xhr = new XMLHttpRequest();
      xhr.open("GET", "../notification.php", true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          const notificationsContainer = document.getElementById('notifications-container');
          notificationsContainer.innerHTML = xhr.responseText;

          // Update notification count
          const notificationCount = notificationsContainer.querySelectorAll('tr').length;
          document.getElementById('notification-count').textContent = notificationCount;
        }
      };
      xhr.send();
    }

    window.onload = fetchNotifications;
    setInterval(fetchNotifications, 30000); // Optional: Fetch every 30 seconds
  </script>
</nav>