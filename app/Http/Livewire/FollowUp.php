<?php

namespace App\Http\Livewire;

use App\Models\ExtraInformation;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;


class FollowUp extends LivewireDatatable
{
    public $hideable = 'select';
    public $exportable = true;
    public $complex = true;
    public $persistComplexQuery = true;

    public function builder()
    {
        return ExtraInformation::query()
            ->with(
                'user',
                'supervisor',
                'myHod',
                'section_one',
                'items',
                'section_two',
                'section_three',
                'section_four',
                'section_five',
                'section_six',
            );
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')->label('#')->defaultSort('asc'),
            Column::name('user.name')->label('Employee Name')->searchable(),
            Column::name('user.department')->label('Department')->filterable($this->department)->searchable(),
            Column::name('user.site')->label('Site')->filterable($this->site),
            Column::name('status')->label('Status')->filterable(),
            Column::name('evaluation_type')->label('Evaluation Type')->filterable(),
            Column::name('Designation')->label('Designation')->filterable(),
            Column::name('sectionTwo.Employee_level:sum')->label('Employee Marks'),
            Column::name('sectionTwo.Supervisor_level:sum')->label('Supervisor Marks'),
            Column::name('sectionTwo.Supervisor_level:count')->label('Marks Out of'),
            Column::name('sectionThree.topic')->label('Type'),
            DateColumn::name('created_at')->label('Date Started')->filterable(),
            Column::callback(['id'], function ($id) {
                return view('livewire.follow-up', ['id' => $id]);
            })->label('Action')
        ];
    }

    public function getDepartmentProperty()
    {
        return array(
            'IT', 'Operations', 'M&E', 'Human Resources',
            'Communications', 'Accounts', 'Operations', 'Human Resources', 'Forestry', 'Miti Magazine'
        );
    }

    public function getSiteProperty()
    {
        return array('Head Office', 'Kiambere', 'Dokolo', 'Nyongoro', '7 Forks', 'Kampala', 'Tanzania');
    }
}
