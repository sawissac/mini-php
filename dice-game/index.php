<?php
session_start();
createSession("user1");
createSession("user2");
createSession("winner");

function setSession(string $name, $value): void
{
  $_SESSION[$name] = json_encode($value);
}

function getSession(String $name)
{
  return json_decode($_SESSION[$name]);
}
function player($name)
{
  $ran = rand(1, 6);
  $data = getSession($name);
  array_push($data, $ran);
  if (count($data) === 3) {
    $total = array_reduce($data, fn ($p, $c) => $p + $c, 0);
    setSession($name . "value", $total);
  }
  setSession($name, $data);
  header("location: index.php");
}

function createSession($name)
{
  // !if name key is not exit it will create user name and it total value
  if (!isset($_SESSION[$name])) {
    setSession($name, []);
  }
  if (!isset($_SESSION[$name . "Total"])) {
    setSession($name . "Total", 0);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple Dice Game</title>
</head>

<body>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">

    <?php
    if ($_SERVER['REQUEST_METHOD'] === "GET") {

      if (isset($_REQUEST['type'])) {
        $type = $_REQUEST['type'];

        if ($type === "again") {
          setSession("user1", []);
          setSession("user2", []);
          setSession("winner", "");
          header("location: index.php");
        }
        if ($type === "user1" && count(getSession("user1")) < 3) {
          player("user1");
        }
        if ($type === "user2" && count(getSession("user2")) < 3) {
          player("user2");
        }
      }
    }
    ?>

    <div>
      <?php
      $user1_random_number = getSession("user1");

      if (count($user1_random_number) !== 0) {
        echo "user1 dice numbers: ";
        array_map(function ($item) {
          echo $item . ",";
        }, $user1_random_number);
        if (count($user1_random_number) >= 3) {
          echo "sum " . getSession("user1value");
        }
      }
      ?>
      <?php if (count($user1_random_number) !== 3) : ?>
        <button type="submit" name="type" value="user1">User One</button>
      <?php endif ?>
    </div>
    <div>
      <?php
      $user2_random_number = getSession("user2");
      if (count($user2_random_number) !== 0) {
        echo "user2 dice numbers: ";
        array_map(function ($item) {
          echo $item . ",";
        }, $user2_random_number);
        if (count($user2_random_number) >= 3) {
          echo "sum " . getSession("user2value");
        }
      }
      ?>
      <?php if (count($user2_random_number) !== 3) : ?>
        <button type="submit" name="type" value="user2">User two</button>
      <?php endif ?>
    </div>

    <?php
    if (count($user1_random_number) == 3 && count($user2_random_number) == 3) {
      $winner = "";
      $user1total = getSession("user1value");
      $user2total = getSession("user2value");
      if ($user1total === $user2total) {
        $winner = "draw";
      } elseif ($user1total > $user2total) {
        $winner = "user1 winner";
      } else {
        $winner = "user2 winner";
      }
      setSession("winner", $winner);
      echo $winner;
    }
    ?>
    <?php if (strlen(getSession("winner")) !== 0) : ?>
      <br />
      <button type="submit" name="type" value="again">Play again</button>
    <?php endif ?>
  </form>
</body>

</html>