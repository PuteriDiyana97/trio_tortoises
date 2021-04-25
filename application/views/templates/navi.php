    <nav class="navbar navbar-expand-lg navbar-dark bg-info static-top">
      <div class="container">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">CodeIgniter Google Maps API</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link<?php echo current_url() == base_url() ? ' active' : ''; ?>" href="<?php echo base_url(); ?>">Get Location</a>
            </li>
            <li class="nav-item">
              <a class="nav-link<?php echo current_url() == base_url('locations') ? ' active' : ''; ?>" href="<?php echo base_url('locations'); ?>">Location List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://github.com/khanhnv24h" target="_blank"><i class="fa fa-github"></i> /khanhnv24h</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>