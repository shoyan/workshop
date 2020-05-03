<header>
  <ul>
    <?php if(empty($_SESSION['login'])): ?> 
      <li><a href="/">ユーザー登録</a></li>
      <li><a href="/login.php">ログイン</a></li>
    <?php else: ?> 
      <li><a href="/logout.php">ログアウト</a></li>
    <?php endif ?> 
  </ul>
</header> 
