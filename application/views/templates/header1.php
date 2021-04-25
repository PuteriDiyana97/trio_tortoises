<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Simple Gis</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css');?>">
    <style>
    </style>
    <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
</head>
<body>
    <div class="navbar navbar-inverse" role="navigation">
    	<div class="container">
	    	<div class="row">
	        	<div class="col-md-12 col-sm-12">
	                <div class="navbar-header">
	                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                  </button>
	                  <a class="navbar-brand" href="<?php echo site_url('admin'); ?>">GIS</a>
	                </div>
	            <ul class="nav navbar-nav">
	            	<li><a href="<?php echo site_url('admin/jalan') ?>">Jalan</a></li>
	            	<li><a href="<?php echo site_url('admin/jembatan') ?>">Jembatan</a></li>
	            	<li><a href="<?php echo site_url('admin/koordinatjalan') ?>">Koordinat Jalan</a></li>
	            	<li><a href="<?php echo site_url('admin/koordinatjembatan') ?>">Koordinat Jembatan</a></li>
	            </ul>
	          </div>
	        </div>
        </div>
    </div>
<!--content-->