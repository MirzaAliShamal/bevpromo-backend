<style type="text/css">
    .hasError{
        border-color: red;
    }
</style>
<div class="modal fade" id="generateCodeModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <input type="hidden" name="coupon_id" id="coupon_id" value="" />
    
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Generate Codes</h4>
        </div>
        
            
            <div class="modal-body">
                <div id="generateCodeFormSection">
                    
                </div>
                <form method="post" action="" enctype="multipart/form-data" id="myform">
                  <div>
                      <label>Choose CSV File to Import</label>
                      <input type="hidden" name="couponId" id="c_id" value="">
                      <input type="file" id="file" name="file" />
                  </div>
                </form>
              <br><br>
              <a href="https://bevpromo-static-assets.serverdatahost.com/sample.csv">Download Sample File</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnImport">Import</button>
                <button type="button" class="btn btn-success" id="btnCodeGenerator">Generate</button>
                <button type="button" class="btn btn-info" id="btnConfigurations">Configurations</button>
                <button type="button" class="btn btn-info" id="btnSaveConfigurations" style="display: none;">Save</button>
                <button type="button" class="btn btn-info" id="btnBackCodeGenerator" style="display: none;">Back</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        
      </div>
    </div>
  </div>