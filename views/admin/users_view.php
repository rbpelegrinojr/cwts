<?php include 'header.php'; ?>

<style>
  #user_table {
    max-width: 100%;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
  }
  .main_content .main_content_iners {
      min-height: 68vh;
      transition: .5s;
      position: relative;
      margin: 0;
      border-radius: 0;
      padding: 30px;
  }
  .main_content .main_content_iners.overly_inners::before {
      position: absolute;
      left: 0;
      top: 0;
      right: 0;
      height: 160px;
      z-index: -1;
      background: #4aa9ff;
      content: '';
      border-radius: 0;
  }
</style>

<div class="main_content_iners overly_inners">
  <div class="container-fluid p-0">
    <div class="row">
      <div class="col-12">
        <h3 class="f_s_30 f_w_700 text_white">USER MANAGEMENT</h3>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="white_card mb_30">
          <div class="white_card_body">

            <?php
              $query = mysqli_query($con, "SELECT * FROM users_tbl WHERE user_type = '0' ORDER BY lname ASC");
              if (mysqli_num_rows($query) == 0) {
                echo '<div class="alert alert-warning"><label>No Data Available.</label></div>';
              }
            ?>

            <div>
              <label><b>Total: <?php echo mysqli_num_rows($query); ?></b></label>
              <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#add_user" style="float: right;">+ Add User</a>
            </div>

            <br>
            <div id="user_table" class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Username</th>
                    <th>College</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $i=1;
                    while ($row = mysqli_fetch_assoc($query)) {
                      $rCN = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM colleges WHERE college_id = '{$row['college_id']}'"));
                      echo "<tr>
                        <td>{$i}</td>
                        <td>{$row['fname']}</td>
                        <td>{$row['lname']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['contact_number']}</td>
                        <td>{$row['username']}</td>
                        <td>{$rCN['college_name']}</td>
                        <td>
                          <button class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editUser{$row['user_id']}'>Edit</button>
                          <a href='../../controller/admin/process/delete_user.php?id={$row['user_id']}' 
                             onclick=\"return confirm('Are you sure you want to delete this user?');\" 
                             class='btn btn-danger btn-sm'>Delete</a>
                        </td>
                      </tr>";

                      // --- EDIT MODAL ---
                      echo "
                      <div class='modal fade' id='editUser{$row['user_id']}' tabindex='-1' role='dialog' aria-hidden='true'>
                        <form action='../../controller/admin/process/update_user.php' method='POST'>
                          <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
                            <div class='modal-content'>
                              <div class='modal-header'>
                                <h3 class='modal-title' style='color: black;'>Edit User</h3>
                                <button type='button' class='close' data-dismiss='modal'><span>&times;</span></button>
                              </div>
                              <div class='modal-body'>
                                <input type='hidden' name='user_id' value='{$row['user_id']}'>
                                <div class='form-group row'>
                                  <div class='col-md-4'>
                                    <label>First Name</label>
                                    <input type='text' name='fname' value='{$row['fname']}' class='form-control' required>
                                  </div>
                                  <div class='col-md-4'>
                                    <label>Last Name</label>
                                    <input type='text' name='lname' value='{$row['lname']}' class='form-control' required>
                                  </div>
                                  <div class='col-md-4'>
                                    <label>Email</label>
                                    <input type='email' name='email' value='{$row['email']}' class='form-control' required>
                                  </div>
                                  <div class='col-md-4'>
                                    <label>Contact Number</label>
                                    <input type='number' name='contact_number' value='{$row['contact_number']}' class='form-control'
                                           required oninput=\"if(this.value.length > 11) this.value = this.value.slice(0, 11);\"
                                           min='9000000000' max='99999999999' title='Please enter a valid 11-digit Philippine contact number (starts with 09)'>
                                  </div>
                                  <div class='col-md-4'>
                                    <label>College</label>
                                    <select name='college_id' class='form-control' required>";
                                      $collegeQuery = mysqli_query($con, "SELECT * FROM colleges ORDER BY college_name ASC");
                                      while ($college = mysqli_fetch_assoc($collegeQuery)) {
                                        $selected = ($college['college_id'] == $row['college_id']) ? 'selected' : '';
                                        echo "<option value='{$college['college_id']}' $selected>{$college['college_name']}</option>";
                                      }
                      echo "        </select>
                                  </div>
                                  <div class='col-md-4'>
                                    <label>Username</label>
                                    <input type='text' name='username' value='{$row['username']}' class='form-control' required>
                                  </div>
                                  <div class='col-md-4'>
                                    <label>Password</label>
                                    <input type='password' name='password' placeholder='Enter new password (optional)' class='form-control'>
                                  </div>
                                </div>
                              </div>
                              <div class='modal-footer'>
                                <input type='submit' class='btn btn-primary' value='Update' name='btnUpdateUser'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>";
                      $i++;
                    }
                  ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ADD USER MODAL -->
<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-hidden="true">
  <form action="../../controller/admin/process/save_user.php" method="POST">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" style="color: black;">Add User</h3>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <div class="col-md-4">
              <label>First Name</label>
              <input type="text" name="fname" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>Last Name</label>
              <input type="text" name="lname" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>

              <input type="hidden" name="email_password" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>Contact Number</label>
              <input 
                type="number" 
                name="contact_number" 
                class="form-control" 
                placeholder="e.g. 09123456789"
                required
                oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11);"
                min="9000000000"
                max="99999999999"
                title="Please enter a valid 11-digit Philippine contact number (starts with 09)">
            </div>
            <div class="col-md-4">
              <label>College</label>
              <select name="college_id" class="form-control" required>
                <option value="">-- Select College --</option>
                <?php
                  $collegeQuery = mysqli_query($con, "SELECT * FROM colleges ORDER BY college_name ASC");
                  while ($college = mysqli_fetch_assoc($collegeQuery)) {
                    echo "<option value='{$college['college_id']}'>{$college['college_name']}</option>";
                  }
                ?>
              </select>
            </div>
            <div class="col-md-4">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>User Type</label>
              <select name="user_type" class="form-control" required>
                <option value="Coordinator">Coordinator</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" value="Save" name="btnSaveCoord">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>
