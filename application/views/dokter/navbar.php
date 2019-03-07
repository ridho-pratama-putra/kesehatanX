<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><img src="<?=base_url()?>assets/images/LOGO YAYASAN.png" style="width: 40px" > KLINIK DU'A</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav mr-auto">
      <li class="nav-item nav-link dropdown" id="logistik">
        <div class=" dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Logistik
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="<?php echo base_url()?>logistik-alat-bahan-sekali-pakai">Logistik alat bahan sekali pakai</a>
          <a class="dropdown-item" href="<?php echo base_url()?>logistik-obat-injeksi">Logistik obat injeksi</a>
          <a class="dropdown-item" href="<?php echo base_url()?>logistik-obat-oral">Logistik obat oral</a>
          <a class="dropdown-item" href="<?php echo base_url()?>logistik-obat-sigma-usus-externum">Logistik obat SUE</a>
          <a class="dropdown-item" href="<?php echo base_url()?>golongan-logistik">Golongan logistik</a>
        </div>
      </li>

      <li class="nav-item" id="antrian">
        <a class="nav-link" href="<?php echo base_url()?>antrian-dokter">Antrian</a>
      </li>
      <li class="nav-item" id="pemeriksaan">
        <a class="nav-link" href="<?php echo base_url()?>pemeriksaan-langsung">Pemeriksaan Langsung</a>
      </li>
      <!-- <li class="nav-item" id="rekam-medis">
        <a class="nav-link" href="<?php echo base_url()?>rekam-medis">Cari Rekam Medis</a>
      </li> -->
      <li class="nav-item" id="list-pasien">
        <a class="nav-link" href="<?php echo base_url()?>list-pasien">List Pasien</a>
      </li>
    </ul>


    <?php 
    if ($this->session->userdata('logged_in') !== array()) { ?>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#"><?=$this->session->userdata('logged_in')['nama_user']?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url()?>logout/">Sign Out</a>
        </li>
      </ul>
    <?php } ?>
  </div>
</nav>

<script type="text/javascript">
  $( document ).ready(function() {
    $("#<?=$active?>").attr("class","active");
    <?=($active == 'logistik' ? "$('#$active').attr('style','margin-top: 8px');" : '')?>
    $(".link-disabled").click(function(e) {
      e.preventDefault();
    });
  });
</script>