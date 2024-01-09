@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <form method="post" action="{{ route('admin.report.current.stock.in.list') }}" id="filterForm">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary" name="type" value="pdf"><i class="fas fa-file-pdf mr-1"></i>পিডিএফ হিসাবে ডাউনলোড করুন</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">নং:</th>
                                        <th>পন্যের তথ্য</th>
                                        <th>বর্তমান মজুদ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($current_stock as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->product_name }}({{ @$list->unit_name }})</td>
                                            <td class="text-right">{{ @$list->available_qty ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(function() {
            $(document).on('click', '[name=type]', function(e) {
                var type = $(this).attr('value');
                if (type == 'pdf') {
                    $('#filterForm').attr('target', '_blank');
                } else {
                    $('#filterForm').removeAttr('target');
                }
            });
        })
    </script>
@endsection
