<?php
namespace App\Modules\Audit\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    public function log(
        string $action,
        string $model,
        int $modelId,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $remark = null
    ) {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'remark' => $remark,
        ]);
    }
}
