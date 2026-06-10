<header class="header">
  <div class="logo">
    <img class="logo-image" src="/nature/explorepage/images/logo.jpeg" alt="Nature Calls Logo">
  </div>

  <nav class="navigation">
    <ul>
      <li><a href="/nature/homepage/home.php">Home</a></li>
      <li><a href="/nature/explorepage/explore.php">Entdecken</a></li>
      <li><a href="/nature/Uber Uns/uberuns.php">Über uns</a></li>
      <li><a href="/nature/Kontakt/kontakt.php">Kontakt</a></li>

      <?php if(isset($_SESSION["user_id"])): ?>
        <li class="user-name"><a href="/nature/profile.php">User: <?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, "UTF-8"); ?></a></li>
        <li><a href="/nature/flights/cart.php">Warenkorb</a></li>
        <li><a href="/nature/logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="/nature/login.php">Login</a></li>
        <li><a href="/nature/register.php">Registrieren</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <div class="name">
    <span>Nature Calls</span>
  </div>
</header>
