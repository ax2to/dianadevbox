<style>
    form.form-horizontal {

    }

    form.form-horizontal input {
    }
</style>
<div id="modalWorkLog" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="form-vertical">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Add Work Log</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::label('project','Project') }}
                        {{ Form::text('project_id') }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('project','Issue') }}
                        {{ Form::text('project_id') }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('project','Date') }}
                        {{ Form::text('project_id') }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('project','Worked') }}
                        {{ Form::text('project_id') }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('project','Description') }}
                        {{ Form::text('project_id') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@push('scripts')
<script>
    $(function () {
        $('form.form-vertical input').addClass('form-control');
    });
</script>
@endpush