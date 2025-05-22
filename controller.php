<?php
namespace Pterodactyl\Http\Controllers\Admin\Extensions\{identifier};
use Illuminate\View\View;
use Illuminate\View\Factory as ViewFactory;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Http\Requests\Admin\AdminFormRequest;
use Illuminate\Http\RedirectResponse;
use Pterodactyl\BlueprintFramework\Libraries\ExtensionLibrary\Admin\BlueprintAdminLibrary as BlueprintExtensionLibrary;

class {identifier}ExtensionController extends Controller
{
    public function __construct(
        private ViewFactory $view,
        private BlueprintExtensionLibrary $blueprint,
    ) {}

    public function index(): View
    {
        $provider = $this->blueprint->dbGet('{identifier}', 'provider') ?: 'disabled';
        $widgetId = $this->blueprint->dbGet('{identifier}', 'widgetId') ?: '';
        $baseUrl = $this->blueprint->dbGet('{identifier}', 'baseUrl') ?: 'https://app.chatwoot.com';

        return $this->view->make(
            'admin.extensions.{identifier}.index', [
                'provider' => $provider,
                'widgetId' => $widgetId,
                'baseUrl' => $baseUrl,
                'root' => "/admin/extensions/{identifier}",
                'blueprint' => $this->blueprint,
            ]
        );
    }

    public function update({identifier}SettingsFormRequest $request): RedirectResponse
    {
        foreach ($request->normalize() as $key => $value) {
            $this->blueprint->dbSet("{identifier}", $key, $value);
        }

        $providerNames = [
            'crisp' => 'Crisp Chat',
            'livechat' => 'LiveChat.com', 
            'chatwoot' => 'Chatwoot',
            'tawk' => 'Tawk.to',
            'tidio' => 'Tidio',
            'zendesk' => 'Zendesk Chat',
            'zoho' => 'Zoho SalesIQ',
            'disabled' => 'Chat Disabled'
        ];

        $provider = $request->input('provider');
        $providerName = $providerNames[$provider] ?? 'Chat';
        
        $this->blueprint->notify("Live chat settings saved - {$providerName}");

        return redirect()->route('admin.extensions.{identifier}.index');
    }
}

class {identifier}SettingsFormRequest extends AdminFormRequest
{
    public function rules(): array
    {
        $rules = [
            'provider' => ['required', 'string', 'in:crisp,livechat,chatwoot,tawk,tidio,zendesk,zoho,disabled'],
        ];

        if ($this->input('provider') !== 'disabled') {
            $rules['widgetId'] = ['required', 'string', 'max:255'];
        }

        if ($this->input('provider') === 'chatwoot') {
            $rules['baseUrl'] = ['required', 'url', 'max:255'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'provider' => 'Chat Provider',
            'widgetId' => 'Widget ID',
            'baseUrl' => 'Base URL',
        ];
    }
}