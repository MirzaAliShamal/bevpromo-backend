@extends('layouts.default-dt')

@push('heads')
    <style>
        #sortable { list-style-type: none; margin: 0; padding: 10px; width: 60%; }
        #sortable li { cursor: pointer; margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em;background: #efefef; margin-top: 5px; font-size: 1.4em; height: 50px; }
        #sortable li span { position: absolute; margin-left: -1.3em; }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#sortable" ).sortable({
                axis: 'y',
                update: function(event, ui) {
                    var data = $(this).sortable('serialize');
                    console.log('data');
                    console.log(data);
                }
            });
        } );
    </script>
@endpush

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            Widget settings form goes here
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn blue">Save changes</button>
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN PAGE HEADER-->
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users"></i>Reorders Coupons
                    </div>
                    <a onclick="submitOrderList()" class="btn red pull-right" role="button">
                        I am done Reordering
                    </a>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="portlet-body form">
                    <div class="">
                        <div class="loader" >

                            <div>
                                <span></span>
                            </div>

                        </div>
                    </div>




                    {{-- Results --}}
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="table-responsive">
                                <form action="/admin/save/reorderList" method="POST" id="submitBtn">
                                <ul id="sortable">
                                    @foreach($coupons as $coupon)
                                        <li class="ui-state-default" data-article-id="{{$coupon->id}}"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                            <input type="hidden" name="coupons[]" value="{{$coupon->id}}" />
                                            {{$coupon->name}}
                                        </li>
                                    @endforeach
                                </ul>

                                    <ul id="originalList" style="list-style: none;" class="ui-state-default">
                                    </ul>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    </div>
@stop

@push('footer-script')
    <script>
        $(document).ready(function () {
            $('#originalList ').html('');
           //get original list
            var params = [];
            $("#sortable").each(function(){
                var items = [];
                $(this).children().each(function(){
                    let value = $(this).data("article-id");
                    params.push({originalList:value});
                })
            });
            params.map((data) => {
                let originaListHtml = '<li class="ui-state-default" data-id="'+ data.originalList +'"><input type="hidden" name="originalList[]" value="'+ data.originalList +'"  /></li>'
                $('#originalList ').append(originaListHtml);
            });
        });
        function submitOrderList(){
            var params = [];
            // $("#sortable").each(function(){
            //     $(this).children().each(function(){
            //         let value = $(this).data("article-id");
            //         params.push({orderList:value});
            //     })
            // });
            // var original = [];
            // $("#originalList").each(function(){
            //     $(this).children().each(function(){
            //         let value = $(this).data("id");
            //         original.push({originalList:value});
            //     })
            // });
            // console.log(params);
            // console.log(original);
           $('#submitBtn').submit();
        }
    </script>
@endpush