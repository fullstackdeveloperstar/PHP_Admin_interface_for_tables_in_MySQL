<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Top Aviva Old
        <small>Add, Edit, Delete</small>
        <!-- <a href="" class="btn btn-success">Add New</a> -->
      </h1>
    </section>
    
    <section class="content">
       <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>topaviva/add"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Top Aviva Old List</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Artista</th>
                        <th>Votos</th>
                        <th>Cancion</th>
                        <th>Image</th>
                        <th>File</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                      if(!empty($topavivalist)){
                        foreach($topavivalist as $aviva){
                          ?>
                          <tr>
                            <td><?=$aviva['artista']?></td>
                            <td><?=$aviva['votos']?></td>
                            <td><?=$aviva['cancion']?></td>
                            <td>
                              <img src="<?=$aviva['img']?>" style="width: 100px;">
                            </td>
                            <td>
                              <audio controls>
                                <source src="<?php echo $aviva['file']; ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                              </audio>
                            </td>
                            <td>
                              <a class="btn btn-sm btn-info" href="<?php echo base_url().'topaviva/edit/'.$aviva["idTopAviva"]; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                              <a class="btn btn-sm btn-danger deleteAviva" href="#" data-id="<?php echo $aviva["idTopAviva"]; ?>" title="Delete"><i class="fa fa-trash"></i></a>
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
  $('.deleteAviva').click(function(){
    var isDel = confirm("Do you want to delete Aritist?");
    if(isDel) {
      var id = $(this).data('id');
      window.location = "<?=base_url()?>topaviva/delete/" + id;
    }
  })
</script>