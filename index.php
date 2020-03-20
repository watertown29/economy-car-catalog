<?php include("includes/init.php");

// open connection to database
$db = open_sqlite_db("secure/catalog.sqlite");

// Get the list of sedans from the database.
$sql = "SELECT * FROM sedans";
$result = exec_sql_query($db, $sql);
$records = $result->fetchAll();

// =do not display submission feedback
$valid_sedan = TRUE;

// =show that the results are from a search
$show_search_feedback = FALSE;

if (isset($_GET['search'])) {

  // Get the search terms
  $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
  $search = trim($search);

  $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING);

  if( strcmp( $category, "msrp" ) === 0){
    $sql = "SELECT * FROM sedans WHERE $category <= :search;";
  } elseif( strcmp( $category, "mpg" ) === 0){
    $sql = "SELECT * FROM sedans WHERE $category >= :search;";
  } else {
    $sql = "SELECT * FROM sedans WHERE $category LIKE '%' || :search || '%';";
  }

  $params = array(
    ':search' => $search
  );

  $result = exec_sql_query($db, $sql, $params);
  $records = $result->fetchAll();
  $show_search_feedback = TRUE;

} else {
  $do_search = FALSE;
  $search = NULL;
}



//print each of the cards with the database info
function print_card($record)
  {
  ?>
    <div class="card">
      <h3><?php echo htmlspecialchars($record["manufacturer"]); ?></h3>
      <h4><?php echo htmlspecialchars($record["model"]); ?></h4>
      <p id="msrp" >MSRP: $<?php echo htmlspecialchars($record["msrp"]); ?>.00</p>
      <P id="mpg" >MPG: <?php echo htmlspecialchars($record["mpg"]); ?></P>
      <p id="ldu" >Last Design Update: <?php echo htmlspecialchars($record["last_design_update"]); ?></p>
    </div>
  <?php
  }

//submit a post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $valid_sedan = TRUE;

  $manufacturer = filter_input(INPUT_POST, 'manufacturer', FILTER_SANITIZE_STRING);
  $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
  $msrp = filter_input(INPUT_POST, 'msrp', FILTER_VALIDATE_INT);
  $mpg = filter_input(INPUT_POST, 'mpg', FILTER_VALIDATE_INT);
  $last_design_update = filter_input(INPUT_POST, 'last_design_update', FILTER_SANITIZE_STRING);

  // all fields, but not last_year_redesign, are required
  if (!$manufacturer || !$model || !$msrp || !$mpg) {
    $valid_sedan = FALSE;
  }

  // insert valid sedan into database
  if ($valid_sedan) {
    $sql = "INSERT INTO sedans (manufacturer, model, msrp, mpg, last_design_update) VALUES ( :manufacturer, :model, :msrp, :mpg, :last_design_update)";

    $param = array(
      ':manufacturer' => $manufacturer,
      ':model' => $model,
      ':msrp' => $msrp,
      ':mpg' => $mpg,
      ':last_design_update' => $last_design_update
    );

    $result = exec_sql_query($db, $sql, $param);

    header("Refresh:0");
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />

  <title>Economy Car Catalog</title>
</head>

<body>

  <header>
      <h1>Economy Car Catalog</h1>
      <h6>Data thanks to www.edmunds.com/sedan/</h6>
  </header>

  <form class="show-all-btn" id="reset-to-all" action="index.php" method="get" novalidate>
      <button type="submit">Show All</button>
  </form>

  <form class="input-form" id="field-search" action="index.php" method="get" novalidate>

  <h3>Search Sedans</h3>

      <select name="category">
        <option value="manufacturer">Manufacturer</option>
        <option value="model">Model</option>
        <option value="msrp">Max MSRP</option>
        <option value="mpg">Minimum MPG</option>
        <option value="last_design_update">Last Design Update</option>
      </select>
      <input type="text" name="search" required />
      <div>
        <button type="submit">Search</button>
      </div>
  </form>





  <form class="add-sedan-form" id="add-sedan" action="index.php" method="post" novalidate>

    <h3>Add a Sedan</h3>

    <div class="manufacturer-input">
      <label>Manufacturer</label>
      <input type="text" name="manufacturer" />
    </div>

    <div class="model-input">
      <label>Model</label>
      <input type="text" name="model" />
    </div>

    <div class="msrp-input">
      <label>MSRP</label>
      <input type="number" name="msrp" />
    </div>

    <div class="mpg-input">
      <label>MPG</label>
      <input type="number" name="mpg" />
    </div>

    <div class="redesign-input">
      <label>Last Year of Redesign</label>
      <input type="text" name="last_design_update" />
    </div>

    <div class="submit-sedan-btn">
      <button type="submit">Submit Sedan</button>
    </div>

    <?php if( $valid_sedan === FALSE ){ ?>
      <h1 class="feedback">Please Fill in All Fields</h1>
    <?php } ?>

    <?php if( $show_search_feedback === TRUE ){ ?>
      <h1 class="search-feedback">Your Search Results</h1>
    <?php } ?>

  </form>

  <section class="catalog">

  <?php
    foreach ($records as $record) {
      print_card($record);
    }
  ?>

  </section>

</body>

</html>
