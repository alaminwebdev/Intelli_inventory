@foreach ($distributeRequisitions as $list)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ @$list->requisition_no ?? 'N/A' }}</td>
        <td>{{ @$list->section->name ?? 'N/A' }}</td>
        <td>{{ @$list->section->department->name ?? 'N/A' }}</td>
        <td class="text-center">{!! requisitionStatus($list->status) !!}</td>
        <td class="text-center">
            <button class="btn btn-sm btn-success view-products" data-toggle="modal" data-target="#productDetailsModal" data-requisition-id="{{ $list->id }}" data-modal-id="productDetailsModal">
                <i class="far fa-eye"></i>
            </button>
            @if (sorpermission('admin.distribute.edit'))
                <a class="btn btn-sm btn-success" href="{{ route('admin.distribute.edit', $list->id) }}">
                    <i class="fa fa-edit"></i>
                </a>
            @endif
        </td>
    </tr>
@endforeach
