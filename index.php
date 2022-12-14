<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="icon" href="./icons/bundle-favicon.ico" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSS only -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <!-- <link rel="stylesheet" href="bootstrap.min.css" /> -->
    <link rel="stylesheet" href="./CSS/style.css" />
    <link rel="stylesheet" href="./CSS/responsive.css" />
    <!-- JavaScript Bundle with Popper -->
    <script
      defer
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <title>Bundle Employee Timesheet</title>
  </head>
  <body>
  <?php include './PHP/variables.php';?>
  <?php include './PHP/functions.php';?>
    <div class="container-fluid">
      <div class="row">

        <!-- Calendar Section -->
        <div class="col-12 col-md-9 bg-light" style="--bs-bg-opacity: 0.25">
          <?php include './PHP/Calendar.php';?>
        </div>

        <!-- Side Panel Section -->
        <div class="col-12 col-md-3 bg-dark text-light bartkaFullColumn" style="padding: 10px; --bs-bg-opacity: 0.5; overflow-y: scroll">
          <?php include './PHP/SidePanel.php';?>
        </div>
      </div>

  </body>
</html>
