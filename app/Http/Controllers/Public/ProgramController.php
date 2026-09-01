<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\Curriculum;
use App\Models\EducationProgram;
use App\Models\Extracurricular;
use App\Models\FeaturedProgram;
use App\Models\StudentOrganization;

class ProgramController extends Controller
{
    public function index()
    {
        return view('public.programs.index', ['programs' => EducationProgram::active()->orderBy('order')->get()]);
    }

    public function show(EducationProgram $program)
    {
        abort_unless($program->status === 'active', 404);

        return view('public.programs.show', compact('program'));
    }

    public function featured()
    {
        return view('public.programs.featured', ['programs' => FeaturedProgram::active()->orderBy('order')->get()]);
    }

    public function curriculum()
    {
        return view('public.programs.curriculum', ['curriculums' => Curriculum::active()->orderBy('order')->get()]);
    }

    public function calendar()
    {
        return view('public.programs.calendar', ['events' => AcademicCalendar::orderByRaw('start_date < ? ASC', [now()->toDateString()])->orderBy('start_date')->paginate(15)]);
    }

    public function extracurricular()
    {
        return view('public.extracurriculars.index', ['extracurriculars' => Extracurricular::active()->orderBy('order')->get()]);
    }

    public function extracurricularShow(Extracurricular $extracurricular)
    {
        abort_unless($extracurricular->status === 'active', 404);

        return view('public.extracurriculars.show', compact('extracurricular'));
    }

    public function organizations()
    {
        return view('public.organizations.index', ['organizations' => StudentOrganization::active()->orderBy('order')->get()]);
    }
}
