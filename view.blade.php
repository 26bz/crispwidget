<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Live Chat Widget Configuration</h3>
  </div>
  <div class="box-body">
    <p class="text-muted">Configure your live chat integration by selecting a provider and entering the required ID/code.</p>

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
        <label for="provider">Chat Provider <span class="text-danger">*</span></label>
        <select name="provider" id="provider" class="form-control" required>
          <option value="">Select a provider...</option>
          <option value="crisp" @if($provider=='crisp' ) selected @endif>Crisp Chat</option>
          <option value="livechat" @if($provider=='livechat' ) selected @endif>LiveChat.com</option>
          <option value="chatwoot" @if($provider=='chatwoot' ) selected @endif>Chatwoot</option>
          <option value="tawk" @if($provider=='tawk' ) selected @endif>Tawk.to</option>
          <option value="tidio" @if($provider=='tidio' ) selected @endif>Tidio</option>
          <option value="zendesk" @if($provider=='zendesk' ) selected @endif>Zendesk Chat</option>
          <option value="zoho" @if($provider=='zoho' ) selected @endif>Zoho SalesIQ</option>
          <option value="disabled" @if($provider=='disabled' || !$provider) selected @endif>Disabled</option>
        </select>
        <small class="form-text text-muted">Choose your live chat provider or disable the widget.</small>
      </div>

      <div class="form-group" id="widget-id-group" style="display: {{ $provider && $provider !== 'disabled' ? 'block' : 'none' }};">
        <label for="widgetId">
          <span id="widget-label">Widget ID</span> <span class="text-danger">*</span>
        </label>
        <input
          type="text"
          name="widgetId"
          id="widgetId"
          value="{{ $widgetId }}"
          placeholder=""
          class="form-control" />
        <small class="form-text text-muted" id="widget-help">
          Enter your widget ID or code from your chat provider.
        </small>
      </div>

      <div class="form-group" id="base-url-group" style="display: {{ $provider == 'chatwoot' ? 'block' : 'none' }};">
        <label for="baseUrl">Chatwoot Base URL <span class="text-danger">*</span></label>
        <input
          type="url"
          name="baseUrl"
          id="baseUrl"
          value="{{ $baseUrl ?? 'https://app.chatwoot.com' }}"
          placeholder="https://app.chatwoot.com"
          class="form-control" />
        <small class="form-text text-muted">Your Chatwoot installation URL (e.g., https://app.chatwoot.com)</small>
      </div>

      {{ csrf_field() }}
      <div class="form-group">
        <button type="submit" name="_method" value="PATCH" class="btn btn-primary">
          <i class="fa fa-save"></i> Save Configuration
        </button>
        @if($provider && $provider !== 'disabled' && $widgetId)
        <button type="button" class="btn btn-info" id="open-dashboard">
          <i class="fa fa-external-link"></i> Open Dashboard
        </button>
        @endif
      </div>
    </form>
  </div>
</div>

@if($provider && $provider !== 'disabled' && $widgetId)
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Integration Status</h3>
  </div>
  <div class="box-body">
    <p><i class="fa fa-check-circle text-success"></i>
      @switch($provider)
      @case('crisp') Crisp Chat @break
      @case('livechat') LiveChat.com @break
      @case('chatwoot') Chatwoot @break
      @case('tawk') Tawk.to @break
      @case('tidio') Tidio @break
      @case('zendesk') Zendesk Chat @break
      @case('zoho') Zoho SalesIQ @break
      @endswitch
      is configured and active on your panel.
    </p>
    <p><strong>Provider:</strong>
      @switch($provider)
      @case('crisp') Crisp Chat @break
      @case('livechat') LiveChat.com @break
      @case('chatwoot') Chatwoot @break
      @case('tawk') Tawk.to @break
      @case('tidio') Tidio @break
      @case('zendesk') Zendesk Chat @break
      @case('zoho') Zoho SalesIQ @break
      @endswitch
    </p>
    <p><strong>Widget ID:</strong> <code>{{ $widgetId }}</code></p>
    @if($provider == 'chatwoot' && $baseUrl)
    <p><strong>Base URL:</strong> <code>{{ $baseUrl }}</code></p>
    @endif
    <p class="text-muted">The chat widget will appear on all admin and user dashboard pages.</p>
  </div>
</div>
@endif

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const providerSelect = document.getElementById('provider');
    const widgetIdGroup = document.getElementById('widget-id-group');
    const baseUrlGroup = document.getElementById('base-url-group');
    const widgetLabel = document.getElementById('widget-label');
    const widgetInput = document.getElementById('widgetId');
    const widgetHelp = document.getElementById('widget-help');
    const openDashboard = document.getElementById('open-dashboard');

    const providerConfig = {
      crisp: {
        label: 'Website ID',
        placeholder: '00000000-0000-0000-0000-000000000000',
        help: 'Find this in your Crisp dashboard.',
        dashboard: 'https://app.crisp.chat/website/{id}/inbox/'
      },
      livechat: {
        label: 'License ID',
        placeholder: '00000000',
        help: 'Find this in your LiveChat dashboard.',
        dashboard: 'https://my.livechatinc.com/'
      },
      chatwoot: {
        label: 'Website Token',
        placeholder: '000000000000000000000000',
        help: 'Find this in your Chatwoot dashboard.',
        dashboard: '{baseUrl}/app/accounts/1/dashboard'
      },
      tawk: {
        label: 'Property ID',
        placeholder: '000000000000000000000000/0000000000',
        help: 'Find this in your Tawk.to dashboard.',
        dashboard: 'https://dashboard.tawk.to/'
      },
      tidio: {
        label: 'Public Key',
        placeholder: '000000000000000000000000000000000000',
        help: 'Find this in your Tidio dashboard.',
        dashboard: 'https://www.tidio.com/panel/dashboard'
      },
      zendesk: {
        label: 'Widget Key',
        placeholder: '00000000-0000-0000-0000-000000000000',
        help: 'Find this in your Zendesk dashboard.',
        dashboard: 'https://dashboard.zendesk.com/'
      },
      zoho: {
        label: 'Widget Code',
        placeholder: 'siq000000000000000000000000000000000000000000000000000000000000000',
        help: 'Find this in your Zoho SalesIQ dashboard. Copy the "wc=" parameter value.',
        dashboard: 'https://salesiq.zoho.com/'
      }
    };

    function updateForm() {
      const provider = providerSelect.value;

      if (provider && provider !== 'disabled') {
        widgetIdGroup.style.display = 'block';
        const config = providerConfig[provider];

        if (config) {
          widgetLabel.textContent = config.label;
          widgetInput.placeholder = config.placeholder;
          widgetHelp.textContent = config.help;
        }

        baseUrlGroup.style.display = provider === 'chatwoot' ? 'block' : 'none';

      } else {
        widgetIdGroup.style.display = 'none';
        baseUrlGroup.style.display = 'none';
      }
    }

    if (openDashboard) {
      openDashboard.addEventListener('click', function() {
        const provider = providerSelect.value;
        const widgetId = widgetInput.value;

        if (provider && widgetId && providerConfig[provider]) {
          let url = providerConfig[provider].dashboard;
          url = url.replace('{id}', widgetId);

          if (provider === 'chatwoot') {
            const baseUrl = document.getElementById('baseUrl').value || 'https://app.chatwoot.com';
            url = url.replace('{baseUrl}', baseUrl);
          }

          window.open(url, '_blank');
        }
      });
    }

    providerSelect.addEventListener('change', updateForm);
    updateForm();
  });
</script>