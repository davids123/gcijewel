@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
    		<div class="card-header">
    			<h1 class="h6">{{translate('User Search Report')}}</h1>
    		</div>
            <div class="card-body">
                <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
                                 <th> <input type="checkbox" class="select_count" id="select_count"  name="all[]"></th>

                            <th>#</th>
                           <th>{{ translate('Search By') }}</th>
                            <th>{{ translate('Number searches') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($searches as $key => $searche)
                            <tr>
                        <td><input type="checkbox" class="pro_checkbox" data-id="{{$searche->id}}" name="all_pro[]" value="{{$searche->id}}"></td>
                                
                                <td>{{ ($key+1) + ($searches->currentPage() - 1)*$searches->perPage() }}</td>
                                <td>{{ $searche->query }}</td>
                                <td>{{ $searche->count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination mt-4">
                    {{ $searches->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>

$(document).on("change", ".check-all", function() {

if(this.checked) {

    $('.check-one:checkbox').each(function() {

        this.checked = true;

    });

} else {

    $('.check-one:checkbox').each(function() {

        this.checked = false;

    });

}



});

$(document).ready(function() {

$(document).on('click','.pro_checkbox',function(){

    productCheckbox();

    productCheckboxExport();

});

});

function productCheckbox()

{

var proCheckID = [];

$.each($("input[name='all_pro[]']:checked"), function(){

    proCheckID.push($(this).val());



});

console.log(proCheckID);

var proexpData =JSON.stringify(proCheckID);

$('#checkox_pro').val(proexpData);

if(proCheckID.length > 0)

{

    $('#product_export').removeAttr('disabled');

}

else

{

    $('#product_export').attr('disabled',true);

}

}
// $('#product_export').on('click',function(){

// })

function productCheckboxExport(){

var proCheckID = [];

$.each($("input[name='all_pro[]']:checked"), function(){

        proCheckID.push($(this).val());

});

var proexpData =JSON.stringify(proCheckID);

$('#checkox_pro_export').val(proexpData);

if(proCheckID.length > 0)

{

    $('#product_export').removeAttr('disabled');

}

else

{

    $('#product_export').attr('disabled',true);

}

}

$(document).on('click','.select_count',function() {

if($(this).is(':checked'))

{

    $('.pro_checkbox').prop('checked', true);

0}

else

{

    $('.pro_checkbox').prop('checked', false);

}

productCheckbox();

productCheckboxExport();

});
</script>
@endsection



