<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><img src="<?=base_url()?>assets/images/LOGO YAYASAN.png" style="width: 40px" > KLINIK DU'A</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">


    <ul class="navbar-nav mr-auto">
      <li class="nav-item" id="antrian">
        <a class="nav-link" href="<?php echo base_url()?>antrian-petugas">Antrian</a>
      </li>
      <li class="nav-item" id="tambah-antrian">
        <a class="nav-link" href="<?php echo base_url()?>cari-pasien-petugas">Tambah Antrian</a>
      </li>
      <li class="nav-item" id="pendaftaran">
        <a class="nav-link" href="<?php echo base_url()?>pendaftaran">Pendaftaran</a>
      </li>
      <li class="nav-item" id="pemeriksaan-awal">
        <a class="nav-link" href="<?php echo base_url()?>pemeriksaan-awal">Pemeriksaan awal</a>
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