<?php

namespace App\Livewire;

use App\Models\Log;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SystemLogs extends Component
{
    use WithPagination;
    #[url(as: 'q')]
    public ?string $search = null;
    public int $pageSize = 5;
    public array $alpineData = [];
    public array $logsHeader = [
        ['field' => 'DATE/TIME', 'sort' => true, 'col' => 'created_at'],
        ['field' => 'USER', 'sort' => true, 'col' => 'user'],
        ['field' => 'USER AGENT', 'sort' => false, 'col' => 'user_agent'],
        ['field' => 'IP ADDRESS', 'sort' => false, 'col' => 'ip_address'],
        ['field' => 'Object Id', 'sort' => false, 'col' => 'object_id'],
        ['field' => 'APP SECTION', 'sort' => false, 'col' => 'app_section'],
        ['field' => 'ACTION', 'sort' => false, 'col' => 'alteration_made'],
    ];

    public function render()
    {
        if ($this->search) {
            $logs = Log::query()
                ->with('user')
                ->whereAny(['created_at', 'user_agent', 'ip_address', 'object_id', 'app_section', 'alteration_made'], 'LIKE', "%{$this->search}%")
                ->orWhereHas('user', function ($query) {
                    $query->where('name', 'LIKE', "%{$this->search}%");
                })->latest()->paginate($this->pageSize);
        } else {
            $logs = Log::query()
                ->with('user')
                ->latest()->paginate($this->pageSize);
        }

        $this->alpineData = collect($logs->toArray()['data'])->map(function ($log) {
            return [
                ...$log,
                'created_at' => Carbon::parse($log['created_at'])->format('Y-m-d, H:i'),
                'user_agent' => $this->getUserAgent($log['user_agent']),
            ];
        })->toArray();

        return view('livewire.system-logs', [
            'logs' => $logs,
        ])->layout('layouts.app');
    }

    protected function getUserAgent(string $rawAgent): string
    {
        return $this->getBrowser($rawAgent) . ' on ' . $this->getOs($rawAgent);
    }

    protected function getBrowser(string $agent): string
    {
        // List of common browsers
        $browsers = ['Edge', 'Chrome', 'Firefox', 'Safari', 'Opera', 'Brave'];

        foreach ($browsers as $browser) {
            if (str_contains($agent, $browser)) {
                return $browser;
            }
        }

        return 'Unknown Browser';
    }

    protected function getOs(string $agent): string {
        // List of common operating systems
        $oses = ['Windows', 'Mac OS', 'Linux', 'Android', 'iOS'];

        foreach ($oses as $os) {
            if (str_contains($agent, $os)) {
                return str_replace(' ', '', $os);
            }
        }

        return 'Unknown OS';
    }
}
