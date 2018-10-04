<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Top Artist Old
        <small>Add</small>
        <!-- <a href="" class="btn btn-success">Add New</a> -->
      </h1>
    </section>
    
    <section class="content">
      <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Artist Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>topartistold/postadd" method="post" id="addartistform" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="artista">Artista</label>
                                        <input type="text" class="form-control" id="artista" placeholder="Artista" name="artista" required="">    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="votos">Votos</label>
                                        <input type="text" class="form-control" id="votos" placeholder="Enter votos" name="votos" required="">
                                    </div>
                                </div>
                            </div>
                            
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="text">Cancion</label>
                                        <input type="text" class="form-control" id="cancion" placeholder="cancion" name="cancion" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="text">Image</label>
                                        <input type="file" class="form-control" id="img"  name="img" required="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>