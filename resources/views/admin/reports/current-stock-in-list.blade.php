@extends('admin.layouts.app')
@section('content')
    <style>
        table,
        thead,
        th,
        tr {
            color: #2a527b !important;
        }

        table tr {
            font-size: 14px !important;
        }

        table.table-bordered.dataTable th,
        table.table-bordered.dataTable td {
            border-left-width: 1px !important;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <form method="post" action="{{ route('admin.report.current.stock.in.list') }}" id="filterForm">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary mr-1" name="type" value="pdf" style="box-shadow:rgba(13, 109, 253, 0.25) 0px 8px 18px 4px"><i class="fas fa-file-pdf mr-1"></i>Download as PDF</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="sb-data-table" class="table table-bordered">
                                <thead style="background: #fff4f4 !important;">
                                    <tr>
                                        <th width="5%">Sl.</th>
                                        <th>Product</th>
                                        <th>Current Stock</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($current_stock as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->product_name }}</td>
                                            <td class="text-right">{{ @$list->available_qty ?? 'N/A' }}</td>
                                            <td class="text-right">{{ @$list->unit_name }}</td>
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
