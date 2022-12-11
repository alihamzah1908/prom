<?php

namespace App\Observers;

use App\Model\Checklist;

class ChecklistObserver
{
    /**
     * Handle the checklist "created" event.
     *
     * @param  \App\Checklist  $checklist
     * @return void
     */
    public function creating(Checklist $checklist)
    {
        if (is_null($checklist->position)) {
            $checklist->position = Checklist::max('position') + 1;
            return;
        }

        $lowerPriorityCategories = Checklist::where('position', '>=', $checklist->position)
            ->get();

        foreach ($lowerPriorityCategories as $lowerPriorityCategory) {
            $lowerPriorityCategory->position++;
            $lowerPriorityCategory->saveQuietly();
        }
    }

    /**
     * Handle the checklist "updated" event.
     *
     * @param  \App\Checklist  $checklist
     * @return void
     */
    public function updating(Checklist $checklist)
    {
        if ($checklist->isClean('position')) {
            return;
        }

        if (is_null($checklist->position)) {
            $checklist->position = Checklist::max('position');
        }

        if ($checklist->getOriginal('position') > $checklist->position) {
            $positionRange = [
                $checklist->position, $checklist->getOriginal('position')
            ];
        } else {
            $positionRange = [
                $checklist->getOriginal('position'), $checklist->position
            ];
        }

        $lowerPriorityCategories = Checklist::where('id_checklist', '!=', $checklist->id)
            ->whereBetween('position', $positionRange)
            ->get();

        foreach ($lowerPriorityCategories as $lowerPriorityCategory) {
            if ($checklist->getOriginal('position') < $checklist->position) {
                $lowerPriorityCategory->position--;
            } else {
                $lowerPriorityCategory->position++;
            }
            $lowerPriorityCategory->saveQuietly();
        }
    }

    /**
     * Handle the checklist "deleted" event.
     *
     * @param  \App\Checklist  $checklist
     * @return void
     */
    public function deleted(Checklist $checklist)
    {
        $lowerPriorityCategories = Checklist::where('position', '>', $checklist->position)
            ->get();

        foreach ($lowerPriorityCategories as $lowerPriorityCategory) {
            $lowerPriorityCategory->position--;
            $lowerPriorityCategory->saveQuietly();
        }
    }

    /**
     * Handle the checklist "restored" event.
     *
     * @param  \App\Checklist  $checklist
     * @return void
     */
    public function restored(Checklist $checklist)
    {
        //
    }

    /**
     * Handle the checklist "force deleted" event.
     *
     * @param  \App\Checklist  $checklist
     * @return void
     */
    public function forceDeleted(Checklist $checklist)
    {
        //
    }
}
