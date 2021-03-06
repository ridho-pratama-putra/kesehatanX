<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><img src="<?=base_url()?>assets/images/LOGO YAYASAN.png" style="width: 40px" > KLINIK DU'A</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav mr-auto">
      <li class="nav-item" id="dashboard">
        <a class="nav-link" href="<?php echo base_url()?>dashboard-admin">Dashboard</a>
      </li>
      <li class="nav-item" id="daftar-dokter">
        <a class="nav-link" href="<?php echo base_url()?>daftar-dokter">Daftar Dokter</a>
      </li>
      <li class="nav-item" id="verifikasi-user">
        <a class="nav-link" href="<?php echo base_url()?>verifikasi-user">Verifikasi User</a>
      </li>
      
    </ul>

    <?php 
    if ($this->session->userdata('logged_in') !== array()) { ?>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url()?>Account/logout/"><?=$this->session->userdata('logged_in')['nama_user']?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url()?>Account/logout/">Sign Out</a>
        </li>
      </ul>
    <?php } ?>
  </div>
</nav>

<script type="text/javascript">
  $( document ).ready(function() {
    $("#<?=$active?>").attr("class","active");
    $(".link-disabled").click(function(e) {
      e.preventDefault();
    });
  });
</script>