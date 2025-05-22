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
        $crispId = $this->blueprint->dbGet('{identifier}', 'crispId');

        return $this->view->make(
            'admin.extensions.{identifier}.index', [
                'crispId' => $crispId,
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
        $this->blueprint->notify('Crisp widget settings have been saved successfully!');

        return redirect()->route('admin.extensions.{identifier}.index');
    }
}

class {identifier}SettingsFormRequest extends AdminFormRequest
{
    public function rules(): array
    {
        return [
            'crispId' => ['required', 'string', 'max:36'],
        ];
    }

    public function attributes(): array
    {
        return [
            'crispId' => 'Crisp ID',
        ];
    }
}