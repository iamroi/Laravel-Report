<?php

/*
 * This file is part of Laravel Reportable.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pmochine\Report\Traits;

use Pmochine\Report\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasReports
{
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function report($data, Model $reporter): Report
    {
        $report = (new Report())->fill(array_merge($data, [
            'reporter_id' => $reporter->id,
            'reporter_type' => get_class($reporter),
        ]));

        $this->reports()->save($report);

        return $report;
    }
}
