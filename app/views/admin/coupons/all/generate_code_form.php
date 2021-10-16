<?php if ($programDetails->is_have_generated_codes == 'Y' && $programDetails->reference_table == '') { ?>
    <form class="" id="frmCouponGenerate" name="frmCouponGenerate" >
        
        <div class="form-group">
            <label for="email">How Many Purchase Codes : </label>
            <input type="purchase_code_count" class="form-control" id="purchase_code_count" />
        </div>
        <div class="form-group">
            <label for="pwd">How Many Winner For Purchase Codes : </label>
            <input type="winning_purchase_code_count" class="form-control" id="winning_purchase_code_count" />
        </div>

<!--        <div class="form-group">
            <label for="pwd">How Many Winning Price : </label>
            <input type="winning_purchase_code_price" class="form-control" id="winning_purchase_code_price" />
        </div>-->
        <div class="form-group">
            <label for="email">How Many Non Purchase Codes : </label>
            <input type="none_purchase_code_count" class="form-control" id="none_purchase_code_count" />
        </div>
        <div class="form-group">
            <label for="pwd">How Many Winner For Non Purchase Codes : </label>
            <input type="winning_none_purchase_code_count" class="form-control" id="winning_none_purchase_code_count" />
        </div>

<!--        <div class="form-group">
            <label for="pwd">How Many Non Winning Purchase Code Price : </label>
            <input type="winning_none_purchase_code_price" class="form-control" id="winning_none_purchase_code_price" />
        </div>-->
    </form>
    
<?php } else { ?>
    <div class="form-group">
        <label for="email">How Many Purchase Codes : <?php echo $totalOnlinePurchaseCode; ?></label>
    </div>
    <div class="form-group">
        <label for="pwd">How Many Winner For Purchase Codes : <?php echo $totalOnlinePurchaseCodeWinner; ?></label>
    </div>
<!--    <div class="form-group">
        <label for="pwd">How Many Winning Price : <?php echo $onlinePurchaseCodeWinnerPrice; ?></label>
    </div>-->
    <div class="form-group">
        <label for="email">How Many Non Purchase Codes : <?php echo $totalOfflinePurchaseCode; ?></label>
    </div>
    <div class="form-group">
        <label for="pwd">How Many Winner For Non Purchase Codes : <?php echo $totalOfflinePurchaseCodeWinner; ?></label>
    </div>
<!--    <div class="form-group">
        <label for="pwd">How Many Non Winning Purchase Code Price : <?php echo $offlinePurchaseCodeWinnerPrice; ?></label>
    </div>-->


    <div class="btn-group">

        <form target="_blank" method="POST" action="" id="exportOnlineGeneratedCodeForm">
            <button name="export" type="button" class="btn btn-default dropdown-toggle"
                    data-toggle="dropdown">
                Export Online Coupon<span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:void(0)" id="exportOnlineGeneratedCodeCsv" data-grid="standard"
                       data-download="csv" data-coupon_id="<?php echo $coupon_id; ?>" data-code_count="<?php echo $totalOnlinePurchaseCode; ?>">Export to CSV</a>
                </li>
<!--                <li><a href="javascript:void(0)" id="exportOnlineGeneratedCodeExcel" data-grid="standard" 
                       data-download="excel" data-coupon_id="<?php echo $coupon_id ?>">Export to Excel</a>
                </li>-->
            </ul>
        </form>

    </div>

    <div class="btn-group">

        <form target="_blank" method="POST" action="" id="exportOfflineGeneratedCodeForm">
            <button name="export" type="button" class="btn btn-default dropdown-toggle"
                    data-toggle="dropdown">
                Export Offline Code<span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:void(0)" id="exportOfflineGeneratedCodeCsv" data-grid="standard"
                       data-download="csv" data-coupon_id="<?php echo $coupon_id; ?>" data-code_count="<?php echo $totalOfflinePurchaseCode; ?>">Export to CSV</a>
                </li>
<!--                <li><a href="javascript:void(0)" id="exportOfflinesGeneratedCodeExcel" data-grid="standard" 
                       data-download="excel" data-coupon_id="<?php echo $coupon_id ?>">Export to Excel</a>
                </li>-->
            </ul>
        </form>

    </div>
<?php } ?>

