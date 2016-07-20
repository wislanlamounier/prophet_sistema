
            <hr/>
            <div class="row">
                <div class="col-md-6">
                    Copyright Prophet
                </div>
                <div class="col-md-6 text-right">
                    <small>© <?php echo date('Y'); ?></small>
                </div>
            </div>
        </div>
        <script src="plugins/jquery/dist/jquery.js"></script>
        <script src="plugins/sweetalert2/dist/sweetalert2.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="plugins/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?= _APP_ROOT_DIR; ?>assets/js/formSubmition.js"></script>
        <script src="<?= _APP_ROOT_DIR; ?>assets/js/browserDetection.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.js"></script>
        <script src="plugins/input-mask/jquery.mask.init.js"></script>
        <?php
            if (isset($js))
                echo $js . PHP_EOL;
            if (isset($css))
                echo $css . PHP_EOL;
            unset($js);
            unset($css);
        ?>
    </body>

</html>