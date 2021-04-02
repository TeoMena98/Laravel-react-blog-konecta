<div class="row">
    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
            <tr>
                <td class="subject"> Category Name</td>
                <td> :</td>
                <td> {{ $category->name }} </td>
            </tr>
            <tr>
                <td class="subject"> Assigned Categories</td>
                <td> :</td>
                <td>
                    @if($category->name === 'admin') {{ 'Admin have all categories by default' }} @endif
                    @php $no= 1; @endphp
                    @foreach($categories as $category)
                        <span class="col-md-4">
                           {{ $no++ . ') ' }} {{ $category->name }}
                      </span>
                    @endforeach
                </td>
            </tr>
            </tbody>
        </table>
    </div>