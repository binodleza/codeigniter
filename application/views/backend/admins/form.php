<link rel="stylesheet" href="<?= base_url() ?>assets/css/site.css">
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Admin</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
 <?php
 $id = (isset($model->admin_id)) ? $model->admin_id : -1;
 ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Admin</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?php
                        if(isset($model->admin_id)){
                            echo form_open_multipart( base_url( 'admins/update/'.$model->admin_id ), array( 'id' => 'my-form', 'class' => 'my-form' ) );
                        }else{
                            echo form_open_multipart( base_url( 'admins/create' ), array( 'id' => 'my-form', 'class' => 'my-form' ) );
                        }
                         ?>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputName">Name</label>
                                <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="name" value="<?= set_value('name', isset($model->name) ? $model->name : ''); ?>">
                                <?php echo form_error('name'); ?>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Email Addresss :', 'exampleInputEmail1'); ?>
                                <?php
                                $data= array(
                                    'name' => 'email',
                                    'placeholder' => 'Enter email',
                                    'class' => 'form-control',
                                    'id' => 'mail_id',
                                    'value' => set_value('email', isset($model->email) ? $model->email : '')
                                );
                                echo form_input($data);
                                ?>
                                <?php echo form_error('email'); ?>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPhone">Phone</label>
                                <input type="text" class="form-control" id="exampleInputPhone" placeholder="Phone" name="phone" value="<?= set_value('phone', isset($model->phone) ? $model->phone : ''); ?>">
                                <?php echo form_error('phone'); ?>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" value="<?php echo set_value('password'); ?>">
                                <?php echo form_error('password'); ?>
                            </div>
                            <div class="form-group"  style="display: <?= isset($model->admin_id) ? 'none' : '' ?>">
                                <label for="exampleInputPassword1">Confirm Password</label>
                                <input type="password" class="form-control"  placeholder="Confirm Password" name="passconf" value="<?php echo set_value('passconf'); ?>">
                                <?php echo form_error('passconf'); ?>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Admin Photo</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- permission box -->
                        <div class="col-md-12">
                            <ul class="tree-make">
                                <h4>Admin Permissions</h4>
                                <hr>
                                <?php
                               // show($result);
                                if (!empty($result)) {
                                    foreach ($result as $row) {
                                           $countModuleRole = countUserModuleRole($id, $row['auth_module_id'], 'A');
                                            $checkAll = 0;
                                            if (sizeof($row['items']) == $countModuleRole) {
                                                $checkAll = 1;
                                            }
                                            ?>
                                            <li style="list-style-type: none;">
                                                <div class="mcollapse" id="module<?php echo $row['auth_module_id']; ?>">
                                                    <input class="i-checks mIcheck" <?php echo ($checkAll == 0) ? '' : 'checked="checked"' ?> id="chk<?php echo $row['auth_module_id']; ?>" type="checkbox" name="module_list[]"
                                                           value="<?php echo $row['auth_module_id']; ?>" onclick="permission.checkUncheckCheckbox(<?php echo $row['auth_module_id']; ?>)"/>
                                                    <a class="pull pull-right showHideNode" onclick="permission.showHideTreeNode(this,<?php echo $row['auth_module_id']; ?>)" href="javascript:;">
                                                        <span class="pull" style="margin: 1px 0px 0 4px;display: inline-block"><b><?php echo $row['auth_module_name']; ?></b></span>
                                                        <i class="fa fa-plus-square-o fa-2x pull pull-right"></i>
                                                    </a>

                                                    <ul class="tree-engine" id="tree-engine-194" style="display:none">
                                                        <?php
                                                        if (!empty($row['items'])) {
                                                            ?>
                                                            <div class="checkbox no-top-padding">
                                                                <ul style="margin: 0px;padding: 0px;">
                                                                    <?php
                                                                    foreach ($row['items'] as $itm) {
                                                                        $hasRole = checkUserHasRole($id, $itm['auth_item_id'], 'A');
                                                                        ?>
                                                                        <li class="chk">
                                                                            <input class="i-checks iIcheck" <?php echo ($hasRole == 0) ? '' : 'checked="checked"' ?> id="itemChk<?php echo $itm['auth_item_id']; ?>" data-module_id="<?php echo $row['auth_module_id']; ?>" type="checkbox" name="item_list[]" value="<?php echo $itm['auth_item_id']; ?>" onclick="permission.checkUncheckItemCheckbox(<?php echo $row['auth_module_id']; ?>,<?php echo $itm['auth_item_id']; ?>)"/>
                                                                            <span class="pull" style="margin: 1px 0px 0 10px;position: absolute"><?php echo $itm['auth_item_name']; ?></span>
                                                                        </li>
                                                                        <!--<br clear="all"/>-->
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </li>
                                            <?php

                                    } }
                                ?>
                            </ul>
                        </div>
                        <!-- permission box end -->










                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <?php echo form_close();?>
                    </div>
                    <!-- /.card -->


                </div>
                <!--/.col (left) -->
                <!-- right column -->

                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div>
    </section>

</div>
<script>
    function saveForm(e) {
        e.preventDefault();
        var form = $('#user-form')[0];
        var formData = new FormData(form);
        $.ajax({
            type: "POST",
            url: '<?= base_url() ?>lawyer/save_user',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                // $('#maskregitr').mask("Please wait .....");
            },
            success: function (response) {
                console.log(response);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }


    $(".mIcheck").on('ifChecked', function (e) {
        permission.checkUncheckCheckbox($(this).val());
    });
    $(".mIcheck").on('ifUnchecked', function (e) {
        permission.checkUncheckCheckbox($(this).val());
    });
    $(".iIcheck").on('ifChecked', function (e) {
        var mid = $(this).data("module_id");
        permission.checkUncheckItemCheckbox(mid,$(this).val());
    });
    $(".iIcheck").on('ifUnchecked', function (e) {
        var mid = $(this).data("module_id");
        permission.checkUncheckItemCheckbox(mid,$(this).val());
    });

</script>

<script src="<?= base_url() ?>assets/js/permission.js"></script>