<form class="" id="frmCodeConfiguration" name="frmCodeConfiguration" method="post" action="">
    <!-- <div class="form-group">
        <label for="email">Sponsor Information : </label>
        <input type="text" class="form-control" id="sponsor_information" name="sponsor_information" value="<?php echo $programDetails->sponsor_information; ?>" />
    </div> -->
    
    <div class="form-group">
        <label for="email">References : </label>
        <button type="button" class="btn btn-info" id="btnAddReason" onclick="bevpromo.coupon_generator.addReason()"><i class="fa fa-plus"></i></button>
    </div>
    <div class="clsReasonSection">
        <?php if(!empty($referenceList)){
            foreach($referenceList as $reference){ ?>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="reason[]" id="reason" placeholder="Enter Reason" value="<?php echo $reference->title;?>" />
                    <input type="hidden" class="form-control" name="reason_id[]" id="reason_id" value="<?php echo $reference->id;?>" />
                </div>
                <div class="col-sm-2">
                        <button type="button" class="btn btn-danger" id="btnDeleteReason" onclick="bevpromo.coupon_generator.deleteReason(<?php echo $reference->id;?>)">Delete</button>
                </div>
            </div>
        <?php }
        } ?>
    </div>
</form>