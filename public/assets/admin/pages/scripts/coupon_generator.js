bevpromo.coupon_generator = {
    initialize:function()
    {
        this.number_of_loop_for_online = 0;
        this.number_of_loop_for_offline = 0;
        this.current_loop_for_online = 0;
        this.current_loop_for_offline = 0;
        this.records_process_per_code = code_generator_limit;
        
        //This is for code generator
        $("#btnCodeGenerator").on("click", function(){
            
            $("#frmCouponGenerate .form-control").removeClass("hasError");
            
            if($("#purchase_code_count").val() == '' || !$.isNumeric($("#purchase_code_count").val())){
                $("#purchase_code_count").addClass("hasError");
            }
            if($("#winning_purchase_code_count").val() == '' || !$.isNumeric($("#winning_purchase_code_count").val())){
                $("#winning_purchase_code_count").addClass("hasError");
            }
            /*if($("#winning_purchase_code_price").val() == '' || !$.isNumeric($("#winning_purchase_code_price").val())){
                $("#winning_purchase_code_price").addClass("hasError");
            }*/
            if($("#none_purchase_code_count").val() == '' || !$.isNumeric($("#none_purchase_code_count").val())){
                $("#none_purchase_code_count").addClass("hasError");
            }
            if($("#winning_none_purchase_code_count").val() == '' || !$.isNumeric($("#winning_none_purchase_code_count").val())){
                $("#winning_none_purchase_code_count").addClass("hasError");
            }
            /*if($("#winning_none_purchase_code_price").val() == '' || !$.isNumeric($("#winning_none_purchase_code_price").val())){
                $("#winning_none_purchase_code_price").addClass("hasError");
            }*/
            
            
            if($(".hasError").length == 0)
            {
                var conf = confirm("Are you sure want to generate code?");
                if(conf)
                {
                    var purchase_code_count = $("#frmCouponGenerate #purchase_code_count").val();

                    var none_purchase_code_count = $("#frmCouponGenerate #none_purchase_code_count").val();


                    var number_of_loop_for_online = parseInt(purchase_code_count/bevpromo.coupon_generator.get_records_per_code());
                    bevpromo.coupon_generator.set_number_of_loop_for_online(number_of_loop_for_online);

                    var number_of_loop_for_offline = parseInt(none_purchase_code_count/bevpromo.coupon_generator.get_records_per_code());
                    bevpromo.coupon_generator.set_number_of_loop_for_offline(number_of_loop_for_offline);

                    //This is to start loader
                    bevpromo.coupon_generator.show_loader();

                    //This is to generate code
                    bevpromo.coupon_generator.coupon_code_generator('Y');
                }
            }
        });
        
        
        //This is for excel generator
        $(document).on('click','#exportOnlineGeneratedCodeCsv, #exportOnlineGeneratedCodeExcel','click',function(){
            var coupon_id = $(this).data('coupon_id');
            var code_count = $(this).data('code_count');
            var is_online_only = 'Y';
            
            //This is to start loader
            bevpromo.coupon_generator.show_loader();
            $(".clsLoader #processedCounts label").html("Total Exported Code : ");
            $(".clsLoader #processedCounts span").html(0);
            $(".clsLoader #processedCounts").show();        
            bevpromo.coupon_generator.export_code_list(coupon_id, code_count, is_online_only, 0);
            /*$('#exportOnlineGeneratedCodeForm input').remove();
            $('#exportOnlineGeneratedCodeForm').attr('action', '/admin/coupons/export_generated_code/export-'+$(this).data('download'));
            $('#exportOnlineGeneratedCodeForm').append('<input type="hidden" name="coupon_id" value="'+$(this).data('coupon_id')+'" />');
            $('#exportOnlineGeneratedCodeForm').append('<input type="hidden" name="is_online_only" value="Y" />');
            $('#exportOnlineGeneratedCodeForm').submit();*/
        });
        
        $(document).on('click','#exportOfflineGeneratedCodeCsv, #exportOfflinesGeneratedCodeExcel','click',function(){
            
            var coupon_id = $(this).data('coupon_id');
            var code_count = $(this).data('code_count');
            var is_online_only = 'N';
            
            //This is to start loader
            bevpromo.coupon_generator.show_loader();
            $(".clsLoader #processedCounts label").html("Total Exported Code : ");
            $(".clsLoader #processedCounts span").html(0);
            $(".clsLoader #processedCounts").show();
            bevpromo.coupon_generator.export_code_list(coupon_id, code_count, is_online_only, 0);
            
            /*$('#exportOfflineGeneratedCodeForm input').remove();
            $('#exportOfflineGeneratedCodeForm').attr('action', '/admin/coupons/export_generated_code/export-'+$(this).data('download'));
            $('#exportOfflineGeneratedCodeForm').append('<input type="hidden" name="coupon_id" value="'+$(this).data('coupon_id')+'" />');
            $('#exportOfflineGeneratedCodeForm').append('<input type="hidden" name="is_online_only" value="N" />');
            $('#exportOfflineGeneratedCodeForm').submit();*/
        });
        
        $("#btnConfigurations").on("click", function(){
            bevpromo.coupon_generator.get_configuration_popup();
        });
        
        $("#btnBackCodeGenerator").on("click", function(){
            var coupon_id = $("#generateCodeModel #coupon_id").val();
            bevpromo.coupon_generator.get_code_generator_form(coupon_id);
        });
        
        $("#btnSaveConfigurations").on("click", function(){
            var coupon_id = $("#generateCodeModel #coupon_id").val();
            bevpromo.coupon_generator.save_code_configuration(coupon_id);
        });
        
    },
    reset_all_count:function(){
        
        this.number_of_loop_for_online = 0;
        this.number_of_loop_for_offline = 0;
        this.current_loop_for_online = 0;
        this.current_loop_for_offline = 0;
        this.records_process_per_code = code_generator_limit;
    },
    show_loader:function(){
        $(".clsLoader").show();
    },
    hide_loader:function(){
        $(".clsLoader").hide();
    },
    get_records_per_code:function(){
        return this.records_process_per_code;
    },
    get_current_loop_for_online: function()
    {
        return this.current_loop_for_online;
    },
    increase_current_loop_for_online: function()
    {
        this.current_loop_for_online++;
    },
    
    get_current_loop_for_offline: function()
    {
        return this.current_loop_for_offline;
    },
    increase_current_loop_for_offline: function()
    {
        this.current_loop_for_offline++;
    },
    
    get_number_of_loop_for_online: function()
    {
        return this.number_of_loop_for_online;
    },
    set_number_of_loop_for_online: function(index)
    {
        this.number_of_loop_for_online = index;
    },
    
    get_number_of_loop_for_offline: function()
    {
        return this.number_of_loop_for_offline;
    },
    set_number_of_loop_for_offline: function(index)
    {
        this.number_of_loop_for_offline = index;
    },
    coupon_code_generator:function(is_online_only){
        
        let coupon_id = $("#generateCodeModel #coupon_id").val();
        var purchase_code_count = $("#frmCouponGenerate #purchase_code_count").val();
        var none_purchase_code_count = $("#frmCouponGenerate #none_purchase_code_count").val();
        var winning_purchase_code_count = $("#frmCouponGenerate #winning_purchase_code_count").val();
        var winning_none_purchase_code_count = $("#frmCouponGenerate #winning_none_purchase_code_count").val();
        //var winning_purchase_code_price = $("#frmCouponGenerate #winning_purchase_code_price").val();
        //var winning_none_purchase_code_price = $("#frmCouponGenerate #winning_none_purchase_code_price").val();
        
        url = BASE_URL+'/admin/coupons/generate_random_codes';
        
        
        $.ajax({
                type:'post',
                url: url,
                data: {
                    coupon_id:coupon_id, 
                    is_online_only:is_online_only, 
                    purchase_code_count:purchase_code_count, 
                    none_purchase_code_count:none_purchase_code_count,
                    winning_purchase_code_count:winning_purchase_code_count,
                    winning_none_purchase_code_count:winning_none_purchase_code_count,
                    /*winning_purchase_code_price:winning_purchase_code_price,
                    winning_none_purchase_code_price:winning_none_purchase_code_price*/
                },
                success: function (result) {
                    var data = JSON.parse(result);
                    if(data.status == 1)
                    {
                        var is_online_generated = 0;
                        if(data.total_online_code_count < purchase_code_count){
                            
                            //This is for set counter
                            $(".clsLoader #processedCounts label").html("Total Purchase Code Generated Count : ");
                            $(".clsLoader #processedCounts span").html(data.total_online_code_count);
                            $(".clsLoader #processedCounts").show();
                        
                            //bevpromo.coupon_generator.increase_current_loop_for_online();
                            bevpromo.coupon_generator.coupon_code_generator('Y');
                        }
                        if(data.total_online_code_count == purchase_code_count)
                        {
                            is_online_generated = 1;
                        }
                        
                        if(is_online_generated == 1)
                        {
                            if(data.total_offline_code_count < none_purchase_code_count){
                                
                                $(".clsLoader #processedCounts label").html("Total NPC Generated Count : ");
                                $(".clsLoader #processedCounts span").html(data.total_offline_code_count);
                                $(".clsLoader #processedCounts").show();
                            
                                //bevpromo.coupon_generator.increase_current_loop_for_offline();
                                bevpromo.coupon_generator.coupon_code_generator('N');
                            }
                        }
                        
                        if(data.is_finished == 1){
                            
                            $(".clsLoader #processedCounts label").html("");
                            $(".clsLoader #processedCounts span").html("");
                            
                            bevpromo.coupon_generator.reset_all_count();
                            bevpromo.coupon_generator.hide_loader();
                            $("#frmCouponGenerate")[0].reset();
                            bevpromo.coupon_generator.get_code_generator_form(coupon_id);
                            //$("#generateCodeModel").modal("hide");
                            return false;
                        }
                    }
                },
//                error: function () {
//                    alert("There is an error");
//                }
        });
    },
    
    get_code_generator_form: function(coupon_id){
        
        bevpromo.coupon_generator.show_loader();
        $("#btnCodeGenerator").show();
        $("#btnBackCodeGenerator").hide();
        $("#btnSaveConfigurations").hide();
        $("#btnConfigurations").show();
        url = BASE_URL+'/admin/coupons/get_code_generator_page';
        $.ajax({
                type:'post',
                url: url,
                data: {
                    coupon_id:coupon_id
                },
                success: function (result) {
                    var data = JSON.parse(result);
                    if(data.status == 1)
                    {
                        $("#generateCodeFormSection").html(data.content);
                        $("#generateCodeModel #coupon_id").val(coupon_id);
                        //bevpromo.coupon_generator.validate_form();
                        if(data.table_name != ''){
                            $("#btnCodeGenerator").hide();
                        }
                        $('#generateCodeModel').modal('show');
                    }
                    bevpromo.coupon_generator.hide_loader();
                },
                error: function () {
                    alert("There is an error");
                }
        });
        
    },
    
    export_code_list: function(coupon_id, code_count, is_online_only, draw)
    {
        var url = BASE_URL+'/admin/coupons/export_generated_code/export-csv';
        $.ajax({
                type:'post',
                url: url,
                data: {
                    coupon_id:coupon_id, 
                    is_online_only:is_online_only, 
                    code_count:code_count,
                    draw:draw
                },
                success: function (result) {
                    var data = JSON.parse(result);
                    if(data.status == 1)
                    {
                        
                        $(".clsLoader #processedCounts label").html("Total Exported Code : ");
                        $(".clsLoader #processedCounts span").html(data.last_exported_id);
                        $(".clsLoader #processedCounts").show();
                        if(data.is_finished == 1){
                            bevpromo.coupon_generator.hide_loader();
                            $(".clsLoader #processedCounts label").html();
                            $(".clsLoader #processedCounts span").html();
                            $(".clsLoader #processedCounts").hide();
                            bevpromo.coupon_generator.download_csv(data.file_path, data.filename);
                            return false;
                        } else {
                            bevpromo.coupon_generator.export_code_list(coupon_id, code_count, is_online_only, data.draw);
                        }
                    }
                },
                error: function () {
                    alert("There is an error");
                }
        });
    },
    
    download_csv: function(file_path, filename){
        
        $('#frmDownloadFile input').remove();
        $('#frmDownloadFile').attr('action', '/admin/coupons/download_exported_code_file');
        $('#frmDownloadFile').append('<input type="hidden" name="file_name" value="'+filename+'" />');
        $('#frmDownloadFile').append('<input type="hidden" name="file_path" value="'+file_path+'" />');
        $('#frmDownloadFile').submit();
    },
    
    get_configuration_popup: function(){
        
        bevpromo.coupon_generator.show_loader();
        
        url = BASE_URL+'/admin/coupons/get_code_configuration_page';
        var coupon_id = $("#generateCodeModel #coupon_id").val();
        
        $.ajax({
                type:'post',
                url: url,
                data: {
                    coupon_id:coupon_id
                },
                success: function (result) {
                    var data = JSON.parse(result);
                    if(data.status == 1)
                    {
                        $("#generateCodeFormSection").html(data.content);
                        $("#btnBackCodeGenerator").show();
                        $("#btnConfigurations").hide();
                        $("#btnSaveConfigurations").show();
                    }
                    bevpromo.coupon_generator.hide_loader();
                },
                error: function () {
                    alert("There is an error");
                }
        });
    },
    
    addReason: function(){
        var inputReason = '<div class="form-group row"><div class="col-sm-10"><input type="text" class="form-control" name="reason[]" id="reason" placeholder="Enter Reason" /></div><div class="col-sm-2"></div></div>';
        $(".clsReasonSection").append(inputReason);
    },
    
    deleteReason: function(id)
    {
       var conf = confirm("Are you sure want to delete Reference?");
       if(conf)
       {
           var url = BASE_URL+'/admin/coupons/delete_code_reason';
           var coupon_id = $("#generateCodeModel #coupon_id").val();
           $.ajax({
                type:'post',
                url: url,
                data: {id:id, coupon_id:coupon_id},
                success: function (result) {
                    var data = JSON.parse(result);
                    if(data.status == 1)
                    {
                        alert(data.message);
                        bevpromo.coupon_generator.get_configuration_popup();
                    }
                    bevpromo.coupon_generator.hide_loader();
                },
                error: function () {
                    alert("There is an error");
                }
        });
       }
     
    }, 
    save_code_configuration: function(){
        url = BASE_URL+'/admin/coupons/save_code_configuration';
        var coupon_id = $("#generateCodeModel #coupon_id").val();
        $.ajax({
                type:'post',
                url: url,
                data: $("#frmCodeConfiguration").serialize()+'&coupon_id='+coupon_id,
                success: function (result) {
                    var data = JSON.parse(result);
                    if(data.status == 1)
                    {
                        alert(data.message);
                        bevpromo.coupon_generator.get_configuration_popup();
                    }
                    bevpromo.coupon_generator.hide_loader();
                },
                error: function () {
                    alert("There is an error");
                }
        });
    }
    
};