<!DOCTYPE html>
<html>

<head>
    <title><?php echo $this->session->userdata['title']; ?> | <?php echo  $this->session->userdata['role']; ?></title>
    <!-- meta -->
    <?php echo @$_meta; ?>
    <!-- css -->
    <?php echo @$_css; ?>
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- ChartJS -->
    <script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- header -->
        <?php echo @$_header; ?>
        <!-- nav -->
        <?php echo @$_nav; ?>
        <!-- sidebar -->
        <?php echo @$_sidebar; ?>
        <!-- content -->
        <?php echo @$_content; ?>
        <!-- headerContent -->
        <!-- mainContent -->
        <!-- footer -->
        <?php echo @$_footer; ?>
    </div>
    <!-- js -->
    <?php echo @$_js;
    if (@$_additional_js != null) {
        echo @$_additional_js;
    } ?>
</body>

</html>