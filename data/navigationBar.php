<div id="nav">
  <div id="nav-wrapper">
    <ul>
      <li><a href="mainItemListing.php">Všechny akce</a></li>
      <li><a href="userEvents.php">Moje akce</a></li>
      <li><a href="newEvent.php">Nová akce</a></li>
      <li><a href="settings.php">Nastavení</a></li>
      <li class="unstyled"><a><?= $currentUser["NAME"]?> <?= $currentUser["SURNAME"]?></a></li>
      <li><a href="signOut.php">Sign out</a></li>
    </ul>
  </div>
</div>

<div class="logo">
        <img src="../resources/TripOut.png" alt="Logo" height="129" width="489">
    </div>