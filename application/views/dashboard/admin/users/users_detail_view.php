<div class="content-wrapper">
  <section class="box box-primary">
    <div class="box-header box-header with-border">
      <h3 class="box-title"><i class="fa fa-file-text-o"></i> Detail Akun</h3>
    </div>
    <div class="box-body">
      <div class="col-xs-12 table-responsive">
        <?php foreach($data_user as $row):?>
          <table class="table table-form">
            <thead>
              <tr>
                <th colspan="2"><h3>Data Pesonal</h3></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td rowspan="5" style="max-width:179px;"><img src="<?php echo base_url();?>/assets/dist/img/avatar04.png" class="user-image" alt="User Image"></td>
                <td>Nama</td>
                <td><?php echo $row->first_name." ".$row->last_name;?></td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td>
                  <?php
                    if(strtolower($row->gender)=="m"){
                      $row->gender="Laki-laki";
                    }
                    elseif(strtolower($row->gender)=="f"){
                      $row->gender="Perempuan";
                    }
                    echo $row->gender;
                  ?>
                </td>
              </tr>
              <tr>
                <td>Tempat Lahir</td>
                <td><?php echo $row->birth_place_name;?></td>
              </tr>
              <tr>
                <td>Tanggal Lahir</td>
                <td><?php echo show_date($row->birth_date,"d/m/Y");?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td><?php echo $row->address;?></td>
              </tr>
            </tbody>
          </table>
          <table class="table table-form">
            <thead>
              <tr>
                <th colspan="2"><h3>Informasi Akun</h3></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Username</td>
                <td><?php echo $row->username;?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><?php echo $row->email;?></td>
              </tr>
              <tr>
                <td>Hak Akses</td>
                <td><?php echo $row->role_name;?></td>
              </tr>
              <tr>
                <td>Tanggal pendaftaran</td>
                <td><?php echo show_date($row->creation_date,"d/m/Y h:i:s");?></td>
              </tr>
            </tbody>
          </table>
        <?php endforeach;?>
      </div>
    </div>
    <div class="box-footer">
      <a onclick="window.print()" target="_blank" class="btn btn-success no-print"><i class="fa fa-print"></i> Print</a>
      <a href="?view=edit&id=<?php echo $row->id;?>" class="btn btn-warning"><i class="ion ion-edit"></i> Edit</a>
      <a href="?act=del&id=<?php echo $row->id;?>" class="btn btn-danger"><i class="ion ion-trash-a"></i> Hapus</a>
      <!-- <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
      </button>
      <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button> -->
    </div>
  </section>
  <!-- /.content -->
  <div class="clearfix"></div>
</div>