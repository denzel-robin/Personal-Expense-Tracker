<?php
  include("session.php");
  
  $one_month_ago = date("Y-m-d", strtotime("-1 month"));
  
  $exp_category_dc = mysqli_query($con, "
    SELECT ec.category_name 
    FROM expense_categories ec
    JOIN expenses e ON ec.category_id = e.category_id
    WHERE e.user_id = '$userid' 
    AND e.expensedate >= '$one_month_ago' 
    GROUP BY e.category_id
  ");
  
  $exp_amt_dc = mysqli_query($con, "
    SELECT SUM(expense) AS expense_sum 
    FROM expenses 
    WHERE user_id = '$userid' 
    AND expensedate >= '$one_month_ago' 
    GROUP BY category_id
  ");

  $one_week_ago = date("Y-m-d", strtotime("-1 week"));
  
  $exp_date_line = mysqli_query($con, "
    SELECT DATE_FORMAT(expensedate, '%b %d') AS day_month 
    FROM expenses 
    WHERE user_id = '$userid' 
    AND expensedate >= '$one_week_ago' 
    GROUP BY expensedate
  ");
  
  $exp_amt_line = mysqli_query($con, "
    SELECT SUM(expense) 
    FROM expenses 
    WHERE user_id = '$userid' 
    AND expensedate >= '$one_week_ago' 
    GROUP BY expensedate
  ");

  $yearly_expenses_query = "
    SELECT YEAR(expensedate) AS year, SUM(expense) AS total_expense
    FROM expenses
    WHERE user_id = '$userid'
    GROUP BY YEAR(expensedate)
    ORDER BY YEAR(expensedate)
  ";
  $yearly_expenses_result = mysqli_query($con, $yearly_expenses_query);
  $year_labels = [];
  $yearly_expense_data = [];
  while ($row = mysqli_fetch_assoc($yearly_expenses_result)) {
      $year_labels[] = $row['year'];
      $yearly_expense_data[] = $row['total_expense'];
  }

  $monthly_expenses_query = "
    SELECT DATE_FORMAT(expensedate, '%Y-%m') AS month_year, SUM(expense) AS total_expense
    FROM expenses
    WHERE user_id = '$userid'
    AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
    GROUP BY DATE_FORMAT(expensedate, '%Y-%m')
    ORDER BY expensedate
  ";
  $monthly_expenses_result = mysqli_query($con, $monthly_expenses_query);
  $monthly_labels = [];
  $monthly_expense_data = [];
  while ($row = mysqli_fetch_assoc($monthly_expenses_result)) {
      $monthly_labels[] = $row['month_year'];
      $monthly_expense_data[] = $row['total_expense'];
  }

  $today_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate = CURDATE()");
  $yesterday_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
  $this_week_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)");
  $this_month_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
  $this_year_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)");
  $total_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid'");

  $today_expense_amount = '0' + mysqli_fetch_assoc($today_expense)['SUM(expense)'];
  $yesterday_expense_amount = '0' + mysqli_fetch_assoc($yesterday_expense)['SUM(expense)'];
  $this_week_expense_amount = '0' + mysqli_fetch_assoc($this_week_expense)['SUM(expense)'];
  $this_month_expense_amount = '0' + mysqli_fetch_assoc($this_month_expense)['SUM(expense)'];
  $this_year_expense_amount = '0' + mysqli_fetch_assoc($this_year_expense)['SUM(expense)'];
  $total_expense_amount = '0' + mysqli_fetch_assoc($total_expense)['SUM(expense)'];
  
  $categories = [];
  $expenses = [];
  
  while ($row = mysqli_fetch_assoc($exp_category_dc)) {
      $categories[] = $row['category_name'];
  }
  
  while ($row = mysqli_fetch_assoc($exp_amt_dc)) {
      $expenses[] = $row['expense_sum'];
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Expense Manager - Dashboard</title>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <script src="js/feather.min.js"></script>
  <style>
    .card a { color: #000; font-weight: 500; }
    .card a:hover { color: #28a745; text-decoration: dotted; }
    .try { font-size: 28px; color: #333; padding: 5px 0px 0px 0px; }
    .container { padding: 0px 20px 20px 20px; }
    .card.text-center { border: 3px solid #ccc; padding: 10px; margin: 10px; background-color: #f8f9fa; border-radius: 5px; }
    .card-title { font-size: 17.5px; margin-bottom: 1px; color: #333; }
    .card-text { font-size: 24px; font-weight: bold; color: #6c757d; }
  </style>
</head>
<body>
  <div class="d-flex" id="wrapper">
    <div class="border-right" id="sidebar-wrapper">
      <div class="user">
        <img class="img img-fluid rounded-circle" src="uploads\default_profile.png" width="120">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
      </div>
      <div class="sidebar-heading">Management</div>
      <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="home"></span> Dashboard</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Expenses</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Manage Expenses</a>
        <a href="expensereport.php" class="list-group-item list-group-item-action"><span data-feather="file-text"></span> Expense Report</a>
      </div>
      <div class="sidebar-heading">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
      </div>
    </div>
    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-light border-bottom">
        <button class="toggler" type="button" id="menu-toggle" aria-expanded="false"><span data-feather="menu"></span></button>
        <div class="col-md-0 text-center">
          <h3 class="try">Dashboard</h3>
        </div>
      </nav>
      <div class="container-fluid">
        <h4 class="mt-4">Full-Expense Report</h4>
        <div class="row">
          <div class="container mt-4">
            <div class="row">
              <div class="col-md-3">
                <div class="card text-center">
                  <div class="card-body">
                    <h5 class="card-title">Today's Expense</h5>
                    <p class="card-text">₹<?php echo $today_expense_amount; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card text-center">
                  <div class="card-body">
                    <h5 class="card-title">Yesterday's Expense</h5>
                    <p class="card-text">₹<?php echo $yesterday_expense_amount; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card text-center">
                  <div class="card-body">
                    <h5 class="card-title">This Week's Expense</h5>
                    <p class="card-text">₹<?php echo $this_week_expense_amount; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card text-center">
                  <div class="card-body">
                    <h5 class="card-title">This Month's Expense</h5>
                    <p class="card-text">₹<?php echo $this_month_expense_amount; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <canvas id="expense_category_pie"></canvas>
          <canvas id="expense_monthly_bar"></canvas>
        </div>
      </div>
    </div>
  </div>
  <script src="js/Chart.min.js"></script>
  <script>
    var categories = <?php echo json_encode($categories); ?>;
    var expenses = <?php echo json_encode($expenses); ?>;

    var ctx = document.getElementById('expense_category_pie').getContext('2d');
    var colors = ['#6f42c1', '#dc3545', '#28a745', '#007bff', '#ffc107', '#20c997', '#17a2b8', '#fd7e14', '#e83e8c', '#6610f2'];

    var myPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: categories,
        datasets: [{
          data: expenses,
          backgroundColor: colors,
          borderWidth: 1
        }]
      },
      options: {
        responsive: true
      }
    });

    var monthlyLabels = <?php echo json_encode($monthly_labels); ?>;
    var monthlyExpenseData = <?php echo json_encode($monthly_expense_data); ?>;

    var ctx2 = document.getElementById('expense_monthly_bar').getContext('2d');
    var myBarChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: monthlyLabels,
        datasets: [{
          label: 'Monthly Expenses',
          data: monthlyExpenseData,
          backgroundColor: '#007bff',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true
      }
    });
  </script>
</body>
</html>
