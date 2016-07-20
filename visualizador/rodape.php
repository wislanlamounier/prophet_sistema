                </div>
                <div class="footer">
                    <div>
                        <strong>Copyright</strong> Prophet &copy; <?php echo date('Y'); ?>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- Scripts !-->
        <script src="tema/js/jquery-2.1.1.js"></script>
        <script src="tema/js/bootstrap.min.js"></script>
        <script src="js/style.js"></script>
        <script src="tema/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="tema/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="tema/js/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="tema/js/inspinia.js"></script>
        <script src="tema/js/plugins/pace/pace.min.js"></script>
        <script src="tema/js/plugins/idle-timer/idle-timer.min.js"></script>
        <script src="tema/js/plugins/idle-timer/idle-timer-init.js"></script> 
        <script src="plugins/sweetalert2/dist/sweetalert2.min.js"></script>
        <script src="js/browserDetection.js"></script>
        <script src="js/formSubmition.js"></script>
        <script src="js/inputborders.js"></script>
        <script src="js/linkPrevent.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.js"></script>
        <script src="plugins/input-mask/jquery.maskmoney.js"></script>
        <script src="plugins/input-mask/jquery.mask.init.js"></script>
        <script src="plugins/select2/dist/js/select2.full.js"></script>
        <script src="plugins/select2/dist/js/select2.init.js"></script>

        <?php
            if(isset($js))
                echo $js.PHP_EOL;
            if(isset($css))
                echo $css.PHP_EOL;
            unset($js);
            unset($css);
        ?>
    </body>
</html>
