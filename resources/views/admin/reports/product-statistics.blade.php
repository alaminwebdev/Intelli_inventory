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
                            <form method="post" action="{{ route('admin.product.statistics') }}" id="filterForm" autocomplete="off">
                                @csrf
                                <div class="form-row p-3 border rounded shadow-sm mb-3">
                                    <div class="form-group col-md-2">
                                        <label class="control-label">দপ্তর <span class="text-red">*</span></label>
                                        <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror select2 ">
                                            <option value="0">All</option>
                                            @foreach ($departments as $item)
                                                <option value="{{ $item->id }}" {{ request()->department_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">শাখা </label>
                                        <select name="section_id" id="section_id" class="form-control select2 @error('section_id') is-invalid @enderror">
                                            <option value="0">All</option>
                                            {{-- @if (request()->section_id) --}}
                                            @foreach ($sections as $item)
                                                <option value="{{ $item->id }}" {{ request()->section_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                            {{-- @endif --}}
                                        </select>
                                        @error('section_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="date_from" class="text-navy">শুরুর তারিখ :</label>
                                        <input type="text" value="{{ request()->date_from }}" name="date_from" class="form-control form-control-sm text-gray singledatepicker" id="date_from" placeholder="শুরুর তারিখ">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="date_to" class="text-navy">শেষ তারিখ :</label>
                                        <input type="text" value="{{ request()->date_to }}" name="date_to" class="form-control form-control-sm text-gray singledatepicker" id="date_to" placeholder="শেষ তারিখ">
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
                                        <th>পন্য</th>
                                        <th>চাহিদার পরিমান</th>
                                        <th>বিতরনের পরিমান</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productStatistics as $list)
                                        <tr>
                                            <td>{{ en2bn($loop->iteration) }}</td>
                                            <td>{{ @$list['product'] ?? 'N/A' }}</td>
                                            <td class="text-right">{{ en2bn(@$list['demand_quantity']) ?? 'N/A' }}</td>
                                            <td class="text-right">{{ en2bn(@$list['distribute_quantity']) ?? 'N/A' }}</td>
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

            $(document).on('change', '#department_id', function() {
                let department_id = $(this).val();
                console.log(department_id);
                $.ajax({
                    url: "{{ route('admin.get.sections.by.department') }}",
                    type: "GET",
                    data: {
                        department_id: department_id
                    },
                    success: function(data) {
                        console.log(data);
                        // Handle the data here
                        let section_div = document.getElementById('section_id');
                        section_div.innerHTML = '<option value="0">All</option>';
                        data.forEach(item => {
                            section_div.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;
                        });
                    }
                });
            });
        });
    </script>
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
