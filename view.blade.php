<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Configuration</h3>
  </div>
  <div class="box-body">
    <p class="text-muted">Configure your Crisp widget integration by entering your Website ID below. You can find this ID in your Crisp dashboard under Settings > Workspace Settings > Setup & Integrations.</p>

    @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form id="config-form" action="" method="POST">
      <div class="form-group">
        <label for="crispId">Crisp Website ID <span class="text-danger">*</span></label>
        <input
          type="text"
          name="crispId"
          id="crispId"
          value="{{ $crispId }}"
          placeholder="00000000-0000-0000-0000-00000000000"
          class="form-control"
          required />
        <small class="form-text text-muted">
          This should be a UUID format (00000000-0000-0000-0000-00000000000).
        </small>
      </div>

      {{ csrf_field() }}
      <div class="form-group">
        <button type="submit" name="_method" value="PATCH" class="btn btn-primary">
          <i class="fa fa-save"></i> Save Configuration
        </button>
        @if($crispId)
        <a href="https://app.crisp.chat/website/{{ $crispId }}/inbox/" target="_blank" class="btn btn-info">
          <i class="fa fa-external-link"></i> Open Crisp Dashboard
        </a>
        @endif
      </div>
    </form>
  </div>
</div>

@if($crispId)
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Integration Status</h3>
  </div>
  <div class="box-body">
    <p><i class="fa fa-check-circle text-success"></i>A Crisp widget is configured and active on your panel.</p>
    <p><strong>Website ID:</strong> <code>{{ $crispId }}</code></p>
    <p class="text-muted">The chat widget will appear on all user dashboard pages.</p>
  </div>
</div>
@endif