<!-- jQuery -->
<script src="<?= base_url('assets/panel') ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/panel') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/panel') ?>/plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?= base_url('assets/panel') ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url('assets/panel') ?>/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="<?= base_url('assets/panel') ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- DataTables -->
<script src="<?= base_url('assets/panel') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/panel') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/panel') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/panel') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?= base_url('assets/panel') ?>/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url('assets/panel') ?>/plugins/toastr/toastr.min.js"></script>
<!-- Slugify -->
<script src="<?= base_url('assets/panel') ?>/plugins/slugify/slugify.min.js"></script>
<script src="<?= base_url('assets/panel') ?>/plugins/slugify/speakingurl.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/panel') ?>/dist/js/adminlte.min.js"></script>
<!-- Summernote -->
<script src="<?= base_url('assets/panel') ?>/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?= base_url('assets/panel') ?>/plugins/summernote/plugin/summernote-ext-rtl/summernote-ext-rtl.js"></script>
<!-- Custom panel js file -->
<script src="<?= base_url('assets/panel') ?>/dist/js/panel.js"></script>
<script>
    // toastr notifications
    toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "positionClass": "toast-top-right",
        "showDuration": "300",
        "hideDuration": "2000",
    }
    <?php if ($session->getFlashdata('toastr_success')) : ?>
        toastr.success('<?= $session->getFlashdata('toastr_success') ?>');
    <?php endif; ?>
    <?php if ($session->getFlashdata('toastr_error')) : ?>
        toastr.error('<?= $session->getFlashdata('toastr_error') ?>');
    <?php endif; ?>
    <?php if ($session->getFlashdata('toastr_warning')) : ?>
        toastr.warning('<?= $session->getFlashdata('toastr_warning') ?>');
    <?php endif; ?>
    <?php if ($session->getFlashdata('toastr_info')) : ?>
        toastr.info('<?= $session->getFlashdata('toastr_info') ?>');
    <?php endif; ?>
</script>
<?= $this->renderSection('<<script>>') ?>