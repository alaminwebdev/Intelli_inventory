@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-info"><i class="fas fa-tachometer-alt mr-1"></i>ড্যাশবোর্ড</a>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.product.expiring.soon') }}" id="filterForm" autocomplete="off">
                                @csrf
                                <div class="form-row p-3 border rounded shadow-sm mb-3">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">দিন বাছাই করুন</label>
                                        <select name="days" id="days" class="form-control select2 ">
                                            <option value=""> বাছাই করুন </option>
                                            <option value="7" {{ request()->days == 7 ? 'selected' : '' }}> ৭ দিন </option>
                                            <option value="15" {{ request()->days == 15 ? 'selected' : '' }}> ১৫ দিন </option>
                                            <option value="30" {{ request()->days == 30 ? 'selected' : '' }}> ৩০ দিন </option>
                                            <option value="60" {{ request()->days == 60 || !request()->has('days') ? 'selected' : '' }}> ৬০ দিন </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label d-block" style="visibility: hidden;">Search</label>
                                        <button type="submit" name="type" value="search" class="btn btn-success btn-sm btn-block">খুজুন</button>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label d-block" style="visibility: hidden;">PDF</label>
                                        <button type="submit" name="type" value="pdf" class="btn btn-info btn-sm btn-block"><i class="fas fa-file-pdf mr-1"></i>পিডিএফ</button>
                                    </div>
                                </div>
                            </form>
                            <table id="" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">নং.</th>
                                        <th width="10%">ক্রয় অর্ডার নং.</th>
                                        <th width="60%">পন্য</th>
                                        <th>মেয়াদ শেষ হবার তারিখ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $rowNumber = 1; // Initialize row number for the group
                                    @endphp
                                    @foreach ($expiringSoonProducts as $poNo => $groupedProducts)
                                        @foreach ($groupedProducts['products'] as $product)
                                            <tr>
                                                <td>{{ en2bn($rowNumber) }}</td>
                                                @if ($loop->first)
                                                    <td rowspan="{{ count($groupedProducts['products']) }}">{{ $poNo }}</td>
                                                @endif
                                                <td>{{ $product->product }}({{ $product->unit }})</td>
                                                {{-- <td>{{ $product->expire_date }}</td> --}}
                                                <td>
                                                    @if ($product->expire_date)
                                                        @php
                                                            $expireDate = \Carbon\Carbon::parse($product->expire_date);
                                                            $daysUntilExpiration = $expireDate->diffInDays(\Carbon\Carbon::now());
                                                        @endphp
                                                        {{ en2bn($daysUntilExpiration) . ' দিনের মধ্যে মেয়াদ শেষ হবে' }}
                                                        {{-- Expire in {{ $daysUntilExpiration }} day{{ $daysUntilExpiration != 1 ? 's' : '' }} --}}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $rowNumber++; // Increment row number for the group
                                            @endphp
                                        @endforeach
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
