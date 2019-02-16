<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><img src="<?=base_url()?>assets/images/LOGO YAYASAN.png" style="width: 40px" > KLINIK DU'A</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav mr-auto">
      <li class="nav-item" id="logistik-alat-bahan-sekali-pakai">
        <a class="nav-link" href="<?php echo base_url()?>logistik-alat-bahan-sekali-pakai">Logistik alat bahan sekali pakai</a>
      </li>
      <li class="nav-item" id="logistik-obat-injeksi">
        <a class="nav-link" href="<?php echo base_url()?>logistik-obat-injeksi">Logistik obat injeksi</a>
      </li>
      <li class="nav-item" id="logistik-obat-oral">
        <a class="nav-link" href="<?php echo base_url()?>logistik-obat-oral">Logistik obat oral</a>
      </li>
      <li class="nav-item" id="logistik-obat-sigma-usus-externum">
        <a class="nav-link" href="<?php echo base_url()?>logistik-obat-sigma-usus-externum">Logistik obat SUE</a>
      </li>
      <li class="nav-item" id="golongan-logistik">
        <a class="nav-link" href="<?php echo base_url()?>golongan-logistik">Golongan logistik</a>
      </li>
      <li class="nav-item" id="antrian">
        <a class="nav-link" href="<?php echo base_url()?>antrian-dokter">Antrian</a>
      </li>
      <li class="nav-item" id="pemeriksaan-langsung">
        <a class="nav-link" href="<?php echo base_url()?>pemeriksaan-langsung">Pemeriksaan Langsung</a>
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
    $(".link-disabled").click(function(e) {
      e.preventDefault();
    });
  });
</script>