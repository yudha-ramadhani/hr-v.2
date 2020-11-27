@extends('layouts.admin')
@section('content')
@can('job_title_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.job-titles.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.jobTitle.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.jobTitle.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-JobTitle">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.main_purpose') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.responsibility') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.result') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.challange') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.authority') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.internal_relation') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.external_relation') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.financial_dimension') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.hr_dimension') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.qualification') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobTitle.fields.training_need') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobTitles as $key => $jobTitle)
                        <tr data-entry-id="{{ $jobTitle->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $jobTitle->id ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->code ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->name ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->main_purpose ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->responsibility ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->result ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->challange ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->authority ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->internal_relation ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->external_relation ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->financial_dimension ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->hr_dimension ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->qualification ?? '' }}
                            </td>
                            <td>
                                {{ $jobTitle->training_need ?? '' }}
                            </td>
                            <td>
                                @can('job_title_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.job-titles.show', $jobTitle->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('job_title_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.job-titles.edit', $jobTitle->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('job_title_delete')
                                    <form action="{{ route('admin.job-titles.destroy', $jobTitle->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('job_title_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.job-titles.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-JobTitle:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
