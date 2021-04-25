<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/navi'); ?>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
	<?php echo $this->session->flashdata('result'); ?>
	<?php if (!empty($locations)){ ?>
				<table class="table table-striped mt-5">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">Description</th>
				      <th scope="col">Latitude</th>
				      <th scope="col">Longitude</th>
				      <th scope="col">Action</th>
				      
				    </tr>
				  </thead>
				  <tbody>
	<?php foreach ($locations as $value): ?>
			    <tr>
			      <td><?php echo $value['description'] ? $value['description'] : 'No description...';  ?></td>
			      <td><?php echo $value['lat'] ?></td>
			      <td><?php echo $value['lng'] ?></td>
			      <td><a href="<?php echo base_url('edit/'); echo $value['id']; ?>" class="btn btn-success mr-2"><i class="fa fa-pencil"></i> Edit</a><a href="<?php echo base_url('delete/'); echo $value['id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a></td>
			      
			    </tr>
<?php endforeach ?>
			  </tbody>
			</table>
<?php } else { ?>
			<table class="table table-striped table-dark mt-3">
			  <thead>
			    <tr>
			      <th scope="col">No data available in table. You must first add a location from <a href="<?php echo base_url(); ?>">home page.</a>.</th>
			    </tr>
			  </thead>
			</table>
<?php } ?>
        </div>
      </div>
	</div>
  </body>
</html>
