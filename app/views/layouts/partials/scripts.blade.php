<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript">
</script>
<script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>

<script src="/data-grid/underscore.js"></script>
<script src="/data-grid/data-grid.js"></script>
<script src="/data-grid/moment.js"></script>
<script src="/data-grid/bootstrap-datetimepicker.js"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>


<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/components-pickers.js"></script>
<script src="/assets/global/scripts/form-components.js"></script>
<script src="/assets/global/plugins/fuelux/js/spinner.min.js"></script>
<script src="/assets/global/plugins/ckeditor/ckeditor.js"></script>
<script src="/assets/global/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script src="/assets/global/plugins/select2/select2.min.js"></script>
<script src="/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script src="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script src="/assets/admin/pages/scripts/form-validation.js"></script>
<!--
<script src="/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
!-->
<script src="/assets/global/plugins/clockface/js/clockface.js"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="/assets/global/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
<script src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script src="/assets/global/plugins/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script src="/assets/global/plugins/jquery.pwstrength.bootstrap/src/pwstrength.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/components-pickers.js"></script>
<script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/assets/js/bootstrap-confirmation.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->

<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        FormComponents.init();
        ComponentsPickers.init();
        UIAlertDialogApi.init();
        FormValidation.init();
        Index.init();
        Index.initCharts(); // init index page's custom scripts
        Index.initIntro();
    });
</script>

<script>
    $(document).on("click","#btnRefreshBrand",function() {
        $('.clsLoader').show();
        // alert("hello");
        //$brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id')->get();
        url='/admin/updatebrand',
        $.ajax({
                url: url,
                success: function (data) {
                    resp = JSON.parse(data);
                    if (resp['success'] == true) {
                
                    var $previousData = $('#brand_id').empty(); // remove previously loaded options
                    let record=resp['record'];
                    for (i in record)
                        $previousData.append('<option value = ' + record[i].id + '>' + record[i].name + '</option>');
                    }
                    $('.clsLoader').hide();
                },
                error: function () {
                    $('.clsLoader').hide();
                    alert("Sorry, There is An error");
                }
            });
    });

    $(document).on("click","#btnRefreshSupplier",function() {
        $('.clsLoader').show();
        // alert("hello");
        //$brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id')->get();
        url='/admin/updateSupplier',
        $.ajax({
                url: url,
                success: function (data) {
                    resp = JSON.parse(data);
                    if (resp['success'] == true) {

                    var $previousData = $('#supplier_id').empty(); // remove previously loaded options
                    let record=resp['record'];
                    console.log('record');
                    console.log(record);
                    for (i in record) {
                            $previousData.append('<option value = ' + record[i].id + '>' + record[i].name + '</option>');
                        }
                        $('.clsLoader').hide();
                    }
                },
                error: function () {
                    $('.clsLoader').hide();
                    alert("Sorry, There is An error");
                }
            });
    });
    $(document).on("click","#btnRefreshOwner",function() {
        $('.clsLoader').show();
        url='/admin/updateowner',
        $.ajax({
                url: url,
                success: function (data) {
                    resp = JSON.parse(data);
                    if (resp['success'] == true) {
                
                    var $previousData = $('#user_id').empty(); // remove previously loaded options
                    let record=resp['record'];
                    for (i in record)
                        $previousData.append('<option value = ' + record[i].id + '>' + record[i].email + '</option>');
                    }
                    $('.clsLoader').hide();
                },
                error: function () {
                    $('.clsLoader').hide();
                    alert("Sorry, There is An error");
                }
            });
    });

    

 $(document).on('click','.imageUpload',function () {
         
    $('#imagesUploadCopy').append('<div class="form-group"><label for="photo_position" class="col-md-4 control-label">Select Photo Position:</label><div class="col-md-5">   <select class="form-control" class="uploadTypeChange" name="photo_position[]"><option value="1">Age Gate</option><option value="2">Promotional Page</option><option value="3">Promotional Ad</option><option value="4">Slider Images</option><option value="5">Web Entry Page</option></select></div></div><div class="form-group"><label for="image_post" class="col-md-4 control-label">Select Image: </label><div class="col-md-6"><input type="file" name="images[1][]" class="img form-control"></div></div>');
        });

    $(function()
    {
        // Setup DataGrid
        var grid = $.datagrid('standard', '.table', '#pagination', '.applied-filters',
            {
                throttle: 20,
                loader: '.loader',
                callback: function(obj)
                {
                    // Select the correct value on the per page dropdown
                    $('[data-per-page]').val(obj.opt.throttle);

                    // Disable the export button if no results
                    $('button[name="export"]').prop('disabled', (obj.pagination.filtered === 0) ? true : false);
                }
            });

        // Date Picker
        $('.datePicker').datetimepicker({
            pickTime: false
        });

       
        /**
         * DEMO ONLY EVENTS
         */
        $('[data-per-page]').on('change', function()
        {
            grid.setThrottle($(this).val());

            grid.refresh();
        });
    });
</script>