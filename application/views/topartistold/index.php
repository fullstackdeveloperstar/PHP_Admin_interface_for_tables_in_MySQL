<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Top Artist Old
        <small>Add, Edit, Delete</small>
        <!-- <a href="" class="btn btn-success">Add New</a> -->
      </h1>
    </section>
    
    <section class="content">
       <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>topartistold/add"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Top Artist Old List</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Artista</th>
                        <th>Votos</th>
                        <th>Cancion</th>
                        <th>Image</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                      if(!empty($topartistoldlist)){
                        foreach($topartistoldlist as $artist){
                          ?>
                          <tr>
                            <td><?=$artist['artista']?></td>
                            <td><?=$artist['votos']?></td>
                            <td><?=$artist['cancion']?></td>
                            <td><img style="width: 100px;" src="<?=$artist['img']?>"></td>
                            <td>
                              <a class="btn btn-sm btn-info" href="<?php echo base_url().'topartistold/edit/'.$artist["idTopArtist"]; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                              <a class="btn btn-sm btn-danger deleteArtist" href="#" data-id="<?php echo $artist["idTopArtist"]; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                          <?php
                        }
                      }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php 
                      echo $this->pagination->create_links(); 
                    ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
  $('.deleteArtist').click(function(){
    var isDel = confirm("Do you want to delete Aritist?");
    if(isDel) {
      var id = $(this).data('id');
      window.location = "<?=base_url()?>topartistold/delete/" + id;
    }
  })
</script>