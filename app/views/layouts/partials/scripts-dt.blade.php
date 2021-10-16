<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
{{-- <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js" type="text/javascript"></script> --}}

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
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
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
<script src="/assets/js/dropzone.js"></script>
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
        console.log('wali shah bukhari');
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

    $(document).on("click","#btnRefreshDEntriesMri",function() {
        console.log('wali shah bukhari');
        $('.clsLoader').show();
        // alert("hello");
        //$brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id')->get();
        url='/admin/update/dmir/danial/reasons',
        $.ajax({
                url: url,
                success: function (data) {
                    resp = JSON.parse(data);
                    if (resp['success'] == true) {

                    var $previousData = $('#denial_reason_id').empty(); // remove previously loaded options
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

    $(document).on("click","#btnRefreshEntriesMri",function() {
        console.log('btnRefreshEntriesMri');
        $('.clsLoader').show();
        // alert("hello");
        //$brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id')->get();
        url='/admin/update/entries/retailer',
        $.ajax({
                url: url,
                success: function (data) {
                    resp = JSON.parse(data);
                    if (resp['success'] == true) {

                    var $previousData = $('#mir_retailer_id').empty(); // remove previously loaded options
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

    $(document).on("click","#btnRefreshEntriesIRC",function() {
        console.log('btnRefreshEntriesIRC');
        $('.clsLoader').show();
        // alert("hello");
        //$brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id')->get();
        url='/admin/update/entries/irc',
        $.ajax({
                url: url,
                success: function (data) {
                    resp = JSON.parse(data);
                    if (resp['success'] == true) {

                    var $previousData = $('#retailer_id').empty(); // remove previously loaded options
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

    $(document).on("click","#btnRefreshCouponIR",function() {
        console.log('btnRefreshCouponIR');
        $('.clsLoader').show();
        // alert("hello");
        //$brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id')->get();
        url='/admin/update/entries/irc/program',
        $.ajax({
                url: url,
                success: function (data) {
                    resp = JSON.parse(data);
                    console.log(resp);
                    if (resp['success'] == true) {

                    var $previousData = $('#coupon_id').empty(); // remove previously loaded options
                    let record=resp['record'];
                    console.log(record);
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

    $(document).on("click","#btnRefreshCleariningIR",function() {
        console.log('btnRefreshCleariningIR');
        $('.clsLoader').show();
        // alert("hello");
        //$brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id')->get();
        url='/admin/update/entries/irc/clearning',
        $.ajax({
                url: url,
                success: function (data) {
                    resp = JSON.parse(data);
                    console.log(resp);
                    if (resp['success'] == true) {

                    var $previousData = $('#clearinghouse_id').empty(); // remove previously loaded options
                    let record=resp['record'];
                    console.log(record);
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

    $(document).on("click","#btnRefreshEntriesMriCop",function() {
        console.log('btnRefreshEntriesMriCop');
        $('.clsLoader').show();
        // alert("hello");
        //$brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id')->get();
        url='/admin/update/entries/mri/coupon',
        $.ajax({
                url: url,
                success: function (data) {
                    resp = JSON.parse(data);
                    console.log(resp);
                    if (resp['success'] == true) {

                    var $previousData = $('#coupon_id').empty(); // remove previously loaded options
                    let record=resp['record'];
                    console.log(record);
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

    
    ////////////////
    $( "#start_date" ).datepicker({
    showOn: "button",
    
    format: 'mm/dd/yyyy',
    changeYear: true,
    changeMonth: true,
    //showMonthAfterYear: true, //this is what you are looking for
    maxDate:0
});
//////////////////
</script>





<script>
    // Date Picker
        $('.datePicker').datetimepicker({
            pickTime: false
        });
        function formateDate(date) {
        let monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", 
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
        let month = date.getMonth();
        let day = date.getDate();
        let year = date.getFullYear();
        let returnDate = monthNames[month] + ' ' + day +', ' + year;
        return returnDate;
    }
    function addFilterHtml(html) {
        let datesLength = $('.dates').length;
        let filtersLength = $('.filters').length;
        if(datesLength == 0 && filtersLength == 0) {
                //First Filter
                $('.applied-filters').html(html);
            }
            else {
                $('.applied-filters').append(html);
            }
    }

    $('#states_valid').hide();
        $(document).on('change','#campaignType',function () {
            let campaighType = $(this).val();
            console.log('campaighType');
            console.log(campaighType);
            if(campaighType == 4) {
                $('#ageGateImg').show();
                $(".sweep-remove").hide();
                $('.sweeptakesPart').show();
                $('#finalUrl').show();
                $('#campaignFavicon').show();
                $('#tabTitle').show();

                let sweep = "<span style='color: #ff0000'>*</span>";
                document.getElementById("SweepstakesName").innerHTML = sweep+"Sweepstakes Name:"
                let dropzoneControl = $('#sweep-upload')[0].dropzone;
                if(dropzoneControl) {
                    dropzoneControl.destroy();
                }
                    Dropzone.autoDiscover = false;
                    var myDropzone = new Dropzone("div#sweep-upload", {
                        addRemoveLinks: true,
                        url: "/admin/coupons/upload-sweep-image",
                        init: function() {
                            this.on("sending", function(file, xhr, formData) {
                                var position = $('#uploadType').val();
                                var couponId = $('#id').val();
                                formData.append("position", position);
                                formData.append("coupon_id", couponId);
                                });
                            this.on('removedfile', function(file){
                                var id = file.id;
                                var couponId = $('#id').val();
                                //There can be an issue if user two users at the same time uploaded to the
                                //server same type of images
                                //Need to handle this scenario in sweepstakes.
                                $.ajax({
                                    type: "POST",
                                    url: '/admin/coupons/delete-sweep-image',
                                    data: {'id': id, 'coupon_id': couponId },
                                    success: function (data) {
                                        res = JSON.parse(data);
                                        var html = res['html'];
                                        $('#uploaded_images').html(html);
                                    },
                                    error: function (error) {
                                            let response = error['responseText'];
                                            alert("Sorry, There is An error " + response);
                                    }
                                });
                            });
                            this.on('success',function(file, response) {
                                res = JSON.parse(response);
                                if(res['success'] == true) {
                                   file.id = res['id'];
                                   var html = res['html'];
                                   $('#uploaded_images').html(html);
                                }
                            });
                        },
                    });

                    myDropzone.on('complete', function (response)
                    {
                        $(".dz-preview").remove();
                        $(".dz-message").show();
                    });
            }
            else {
                $('#ageGateImg').hide();
                $('.sweeptakesPart').hide();
                $(".sweep-remove").show();
                $(".dmir-remove").show();
            }
            if(campaighType == 3) {
                $('.digitalmirPart').show();
                $('#faqSection').show();
                $('#defaultfaqSection').show();
                $('#addEditModelAndGenerateCode').hide();
                $(".sweep-remove").show();
                $('#brand_privacy').show();
            }
            else {
                $('.digitalmirPart').hide();
                $('#faqSection').hide();
                $('#defaultfaqSection').hide();
                $('#addEditModelAndGenerateCode').show();
                $('#brand_privacy').hide();
            }
            if (campaighType == 3 || campaighType == 4) {
                $("#barcodeDiv").hide();   
            }
            else{
                
                $('#barcodeDiv').show();
            }
        });
        // SWEEPTAKES IMAGE TAKES
        var imageCount = 2;
        $(document).on('click','.imageUpload',function () {
         
            $('#imagesUploadCopy').append('<div class="border col-sm-10" style="margin-top:10px"><div class="form-group"><label for="photo_position" class="col-md-4 control-label">Select Photo Position:</label><div class="col-md-5">   <select class="form-control uploadTypeChange" data-id="'+imageCount+'" name="photo_position['+imageCount+'][]"><option value="1">Age Gate</option><option value="2">Promotional Page</option><option value="3">Promotional Ad</option><option value="4">Slider Images</option><option value="5">Web Entry Page</option></select></div></div><div class="form-group"><label for="image_post" class="col-md-4 control-label">Select Image: </label><div class="col-md-6 imageCopy_'+imageCount+'" ><input type="file" name="images['+imageCount+'][]" class="img form-control"></div><div class="col-md-2"><a class="imageCopy" data-id="'+imageCount+'" href="javascript:void(0)"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></div> </div></div>');
            imageCount++;
       });

       $(document).on('click', '.addFaq', function() {
           var html = `
                <div class="qaDiv">
                    <div class="form-group">
                        <label for="question" class="col-md-2 control-label">Question: </label>
                        <div class="col-md-10">
                            <input type="text" name="question[]" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="answer" class="col-md-2 control-label">answer: </label>
                        <div class="col-md-10">
                            <textarea class="ckeditor answer" name="answer[]" rows="2" cols="20"></textarea>
                        </div>
                    </div>
                    <div class="text-center" style="margin-bottom:5px;">
                        <a class="removeFaq" href="javascript:void(0)"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span></a>
                    </div>
                </div>
            `;
            $('#faqCopy').append(html);
            CKEDITOR.replaceAll("answer");
       });
        $("body").on("click",".removeFaq",function(){ 
            $(this).parents(".qaDiv").remove();
        });
        $(document).on('click','.imageCopy',function () {
            
            var dataId = $(this).data('id');
    
            var fieldImage = $('.imageCopy_'+dataId).html();
            
            $('.imageCopy_'+dataId).append(fieldImage);
            
       });

       $(document).on('change','.uploadTypeChange',function(){
           var v = $(this).val();
           var prevId = $(this).data('id');
           // SET CURRENT POSITION
           $(this).attr('data-id',v);        
          $('.imageCopy_'+prevId).find('input:file').attr('name','images['+v+'][]');
        });
        $(document).on('click','.deleteSweepImage',function(){
        $(this).remove();
           var imageId = $(this).data('id');
           var couponId = $(this).data('coupon-id');
           var formData = {'id':imageId, 'coupon_id': couponId};
           url = '/admin/coupons/delete-sweep-image';
           $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                /* processData: false,
                contentType: false, */
                success: function(data) {
                    $('.delete_'+imageId).remove();           
                },
                error: function(error) {
                    let response = error['responseText'];
                    alert("Sorry, There is An error " + response);
                }
            });
          
        });
        $(document).on('click','.campaign_url',function(e) {
                e.preventDefault();
                navigator.clipboard.writeText(e.target.getAttribute('href')).then(() => {
                    alert('Link Copied')
                    }, () => {
                        alert('Error');
                        });
                
        });
 
       $(document).on('click','.deleteImage',function(){
        $(this).remove();
           var imageId = $(this).data('id');
           var formData = {'image_id':imageId};
           url = '/admin/delete/image';
           $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                /* processData: false,
                contentType: false, */
                success: function(data) {
                    if(data.success == true){
                        
                    }
                    
                    $('.delete_'+imageId).remove();
           
                },
                error: function(error) {
                    let response = error['responseText'];
                    alert("Sorry, There is An error " + response);
                }
            });
          
        });
        $(document).on('click','.campaign_url',function(e) {
                e.preventDefault();
                navigator.clipboard.writeText(e.target.getAttribute('href')).then(() => {
                    alert('Link Copied')
                    }, () => {
                        alert('Error');
                        });
                
        });
        $('.datepicker-jq').datepicker({
format: 'mm-dd-yyyy',
autoclose: true,
todayHighlight: true,
});
function initDatepicker() {
$('.wrapper').find('.datepicker-jq').each(function(i, e) {
$(this).removeClass('hasDatepicker').datepicker({
  format: 'mm-dd-yyyy',
  autoclose: true,
  todayHighlight: true,
});
});
}
$('.datepicker-jq1').datepicker({
format: 'mm-dd-yyyy',
autoclose: true,
todayHighlight: true,
});
function initDatepicker() {
$('.wrapper').find('.datepicker-jq1').each(function(i, e) {
$(this).removeClass('hasDatepicker').datepicker({
  format: 'mm-dd-yyyy',
  autoclose: true,
  todayHighlight: true,
});
});
}



$.fn.modal.Constructor.prototype.enforceFocus = function() {};
</script>
@stack('footer-script')