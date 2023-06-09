<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employees</li>
        <li class="active">Employee List</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Employee ID</th>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Department</th>
                  <!-- <th>Supervisor</th> -->
                  <th>Schedule</th>
                  <th>Member Since</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN departments ON departments.id=employees.department_id LEFT JOIN schedules ON schedules.id=employees.schedule_id";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      ?>
                        <tr>
                          <td><?php echo $row['employee_id']; ?></td>
                          <td><img src="<?php echo (!empty($row['photo']))? '../images/'.$row['photo']:'../images/profile.jpg'; ?>" width="30px" height="30px"> <a href="#edit_photo" data-toggle="modal" class="pull-right photo" data-id="<?php echo $row['empid']; ?>"><span class="fa fa-edit"></span></a></td>
                          <td><?php echo $row['firstname'].' '.$row['lastname']; ?></td>
                          <td><?php echo $row['description']; ?></td>
                          <td><?php echo $row['name']; ?></td>
                          <!-- <td><?php echo $row['supervisor']; ?></td> -->
                          <td><?php echo date('h:i A', strtotime($row['time_in'])).' - '.date('h:i A', strtotime($row['time_out'])); ?></td>
                          <td><?php echo date('M d, Y', strtotime($row['created_on'])) ?></td>
                          <td>
                            <?php
                              if($row['position_id'] == 3)
                              {
                                echo"<button class='btn btn-success btn-sm create btn-flat' data-id='". $row['empid'] . "'><i class='fa glyphicon glyphicon-plus'></i> Create</button>";                       
                              }
                            ?>
                            <button class="btn btn-warning btn-sm edit btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-edit"></i> Edit</button>
                            <?php
                              if($row['position_id'] != 3)
                              {
                                echo"<button class='btn btn-primary btn-sm assign btn-flat' data-id='". $row['empid'] . "'><i class='fa fa-arrow-left'></i> Assign to</button>";
                              }
                            ?>
                            <button class="btn btn-danger btn-sm delete btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-trash"></i> Delete</button>
                            <!-- <button class="btn btn-info btn-sm report btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-file"></i> Report</button> -->
                          </td>
                        </tr>
                      <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/employee_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('.assign').click(function(e){
    e.preventDefault();
    $('#assign').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
  $('.create').click(function(e){
    e.preventDefault();
    $('#create').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
  $('.report').click(function(e){
    e.preventDefault();
    $('#report').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.photo').click(function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'employee_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.empid').val(response.empid);
      $('.supervisor').val(response.empid);
      // $('supervisor').val(response.employee_id);
      $('.employee_id').html(response.employee_id);
      $('.del_employee_name').html(response.firstname+' '+response.lastname);
      $('#employee_name').html(response.firstname+' '+response.lastname);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_address').val(response.address);
      $('#user_firstname').val(response.firstname);
      $('#user_lastname').val(response.lastname);
      $('#user_photo').val(response.photo);
      $('#datepicker_edit').val(response.birthdate);
      $('#edit_contact').val(response.contact_info);
      $('.id').val(response.employee_id);
      $('#id').val(response.employee_id);
      $('.positionid').val(response.position_id);
      $('#positionid').val(response.position_id);
      $('#gender_val').val(response.gender).html(response.gender);
      $('.position').val(response.position_id);
      $('#position_val').val(response.position_id).html(response.description);
      $('#department_val').val(response.department_id).html(response.name);
      $('#schedule_val').val(response.schedule_id).html(response.time_in+' - '+response.time_out);
    }
  });

  // $('.input-daterange').datepicker({
  //   todayBtn:"linked",
  //   format:"yyyy-mm-dd",
  //   autoclose:true,
  //   container: '#report modal-body'
  // });
  // $(document).on('click', '.report_button', function(){
  //   var employee_id = $(this).attr('id');
  //   $('#employee_id').val(employee_id);
  //   $('#report').modal('show');
  // });

  // $('#create_report').click(function(){
  //   var employee_id = $('employee_id').val();
  //   var from_date = $('#from_date').val();
  //   var to_date = $('#to_date').val();
  //   var error = 0;
  //   if (from_date == '')
  //   {
  //     $('#error_from_date').text('From Date is Required');
  //     error++;
  //   }
  //   else 
  //   {
  //     $('#error_from_date').text('');
  //   }
  //   if(to_date == '')
  //   {
  //     $('#error_to_date').text('To Date is Required');
  //     error++;
  //   }
  //   else
  //   {
  //     $('#error_to_date').text('');
  //   }

  //   if($error == 0)
  //   {
  //     $('#from_date').val('');
  //     $('#to_date').val('');
  //     $('#report').modal('hide');
  //     window.open(location.href
  //   }
  // });
}
</script>
</body>
</html>
