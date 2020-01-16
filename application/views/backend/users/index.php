<style>
 .pagination li a   {
        position: relative;
        display: block;
        padding: .5rem .75rem;
        margin-left: -1px;
        line-height: 1.25;
        color:
                #007bff;
        background-color:
                #fff;
        border: 1px solid
        #dee2e6;
    }
    .pagination .active a {
        background: #0087ff4a;
        color: black;
    }
    </style>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php
            //show($list);
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Image</th>
                                <th>Device Token</th>
                                <th>is Active</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>

                              <?php
                              $i = 0;
                              if(!empty($list)){
                                  foreach ($list as $row){
                                     ?>
                              <tr>
                                      <td style="width: 10px"><?= ++$i ?></td>
                                      <td><?= $row->first_name.' '.$row->last_name ?></td>
                                      <td><?= $row->email ?></td>
                                      <td><?= $row->phone ?></td>
                                      <td><?= $row->image ?></td>
                                      <td><?= $row->device_token ?></td>
                                      <td>
                                          <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" id="customSwitch-<?= $row->user_id ?>" <?= ($row->is_active == 1) ? 'checked' : '' ?> onchange="app.changeStatus('Users/changeStatus', '<?= $row->user_id ?>');">
                                              <label class="custom-control-label" for="customSwitch-<?= $row->user_id ?>"></label>
                                          </div>
                                      </td>
                                  <td>View / Update / Delete  </td>
                              </tr>
                                <?php

                                  }
                              }
                              ?>




                            </tbody>
                        </table>

                        <div class="col-md-11">
                        <ul class="pagination">
                            <?php echo $links; ?>
                        </ul>
                        </div>
                        <!-- Default checked -->

                    </div>
                </div>
            </div>


        </div>
    </section>
</div>
